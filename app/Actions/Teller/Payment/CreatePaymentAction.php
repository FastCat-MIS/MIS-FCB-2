<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
use App\Models\Teller\TempBooking;
use App\Models\Teller\Booking;
use App\Models\Teller\BookedPassenger;
use App\Models\Teller\BookedVehicle;
use App\Models\Teller\PermanentBookedPassenger;
use App\Models\Teller\PermanentBookedVehicle;
use App\Models\Teller\ScheduleSeatLock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePaymentAction extends Action
{
    public function execute(array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            'serial_no' => 'required|string|max:50',
            'total_fare' => 'required|numeric|min:0',
            'total_discount' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'total_admin_fee' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'reference_number' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($validator) {
            $validated = $validator->validated();
            
            // Auto-populate created_by from JWT token
            $createdBy = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');
            $validated['created_by'] = $createdBy;

            // Log the serial number being used for transfer
            \Log::info("Processing payment with serial_no: {$validated['serial_no']}");

            // Find the temp_booking
            $tempBooking = TempBooking::where('serial_no', $validated['serial_no'])->first();
            if (!$tempBooking) {
                throw new \Exception("No booking found with serial_no: {$validated['serial_no']}");
            }

            // 🎯 GENERATE NEW BOOKING NUMBER (incremental format: 7EA5-00001)
            $bookingNumber = $this->generateBookingNumber();
            \Log::info("Generated booking_number: {$bookingNumber} for serial_no: {$validated['serial_no']}");

            // Create permanent booking (but don't delete temp yet!)
            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'schedule_booking_id' => $tempBooking->schedule_booking_id,
                'is_return_trip' => $tempBooking->is_return_trip,
                'travel_date' => $tempBooking->travel_date,
                'schedule_id' => $tempBooking->schedule_id,
                'schedule_snapshot' => $tempBooking->schedule_snapshot,
                'route_id' => $tempBooking->route_id,
                'route_snapshot' => $tempBooking->route_snapshot,
                'vessel_snapshot' => $tempBooking->vessel_snapshot,
                'institutional_account_id' => $tempBooking->institutional_account_id,
                'institutional_account_snapshot' => $tempBooking->institutional_account_snapshot,
                'booking_origin' => $tempBooking->booking_origin ?? 'teller',
                'created_by' => $createdBy,
            ]);
            
            \Log::info("Created permanent booking with ID: {$booking->booking_id}");

            // Transfer passengers from temporary to permanent tables and get ID mapping
            $passengerIdMap = $this->transferPassengersToPermanent($validated['serial_no'], $booking->booking_id);

            // Transfer vehicles from temporary to permanent tables with passenger ID mapping
            $this->transferVehiclesToPermanent($validated['serial_no'], $booking->booking_id, $passengerIdMap);

            // 🔒 UPDATE SEAT LOCKS: serial_no → booking_number AND mark as permanent
            $updatedLocks = ScheduleSeatLock::where('serial_no', $validated['serial_no'])
                ->update([
                    'serial_no' => $bookingNumber,  // Replace temp serial_no with permanent booking_number
                    'expires_at' => null            // Mark as permanent
                ]);
            \Log::info("Updated {$updatedLocks} seat locks from serial_no: {$validated['serial_no']} to booking_number: {$bookingNumber}");

            // NOW delete temp_booking after passengers/vehicles are transferred
            $tempBooking->delete();
            \Log::info("Deleted temp_booking ID: {$tempBooking->temp_booking_id}");

            // Create payment linked to the booking
            $paymentData = [
                'booking_id' => $booking->booking_id,
                'total_fare' => $validated['total_fare'],
                'total_discount' => $validated['total_discount'],
                'grand_total' => $validated['grand_total'],
                'total_admin_fee' => $validated['total_admin_fee'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['reference_number'] ?? null,
                'created_by' => $createdBy,
            ];
            
            $payment = BookingPayment::create($paymentData);

            // Load the transferred data for the response
            $payment->load(['bookedPassengers', 'bookedVehicles']);
            
            // Load booking with snapshots
            $booking->load(['passengers', 'vehicles']);

            return $this->success([
                'payment' => $payment,
                'booking' => $booking,
            ], 'Payment processed successfully. Booking and passengers/vehicles transferred to permanent storage.', 201);
        });
    }

    private function transferPassengersToPermanent(string $serialNo, int $bookingId): array
    {
        // Get temp booking first
        $tempBooking = TempBooking::where('serial_no', $serialNo)->first();
        
        if (!$tempBooking) {
            \Log::warning("No temp booking found with serial_no: {$serialNo}");
            return [];
        }

        // Get passengers through relationship
        $temporaryPassengers = $tempBooking->passengers;

        \Log::info("Transferring passengers for serial_no: {$serialNo}, found: " . $temporaryPassengers->count() . " records");

        if ($temporaryPassengers->isEmpty()) {
            \Log::warning("No passengers found for temp_booking_id: {$tempBooking->temp_booking_id}");
            return [];
        }

        $idMapping = []; // Map temp ID to permanent ID

        foreach ($temporaryPassengers as $tempPassenger) {
            try {
                $permanentPassenger = PermanentBookedPassenger::create([
                    'booking_id' => $bookingId,
                    'fullname' => $tempPassenger->fullname,
                    'gender' => $tempPassenger->gender,
                    'passenger_type_id' => $tempPassenger->passenger_type_id,
                    'passenger_type_snapshot' => $tempPassenger->passenger_type_snapshot,
                    'passenger_category_id' => $tempPassenger->passenger_category_id,
                    'passenger_category_snapshot' => $tempPassenger->passenger_category_snapshot,
                    'seat_id' => $tempPassenger->seat_id,
                    'seat_number_snapshot' => $tempPassenger->seat_number_snapshot,
                    'fare' => $tempPassenger->fare,
                    'discount_amount' => $tempPassenger->discount_amount,
                    'discount_id' => $tempPassenger->discount_id,
                    'created_by' => $tempPassenger->created_by,
                    'expires_at' => null,
                ]);

                // Map temp ID to permanent ID
                $idMapping[$tempPassenger->booked_passenger_id] = $permanentPassenger->booked_passenger_id;

                // Permanently delete from temporary table
                $tempPassenger->forceDelete();
                \Log::info("Transferred passenger ID: {$tempPassenger->booked_passenger_id} to permanent ID: {$permanentPassenger->booked_passenger_id}");
            } catch (\Exception $e) {
                \Log::error("Failed to transfer passenger ID: {$tempPassenger->booked_passenger_id}. Error: " . $e->getMessage());
            }
        }

        return $idMapping;
    }

    private function transferVehiclesToPermanent(string $serialNo, int $bookingId, array $passengerIdMap = []): array
    {
        // Get temp booking first
        $tempBooking = TempBooking::where('serial_no', $serialNo)->first();
        
        if (!$tempBooking) {
            \Log::warning("No temp booking found with serial_no: {$serialNo}");
            return [];
        }

        // Get vehicles through relationship
        $temporaryVehicles = $tempBooking->vehicles;

        \Log::info("Transferring vehicles for serial_no: {$serialNo}, found: " . $temporaryVehicles->count() . " records");

        if ($temporaryVehicles->isEmpty()) {
            \Log::warning("No vehicles found for temp_booking_id: {$tempBooking->temp_booking_id}");
            return [];
        }

        $transferredVehicles = [];

        foreach ($temporaryVehicles as $tempVehicle) {
            try {
                // Map temp driver_passenger_booking_id to permanent ID
                $permanentDriverId = null;
                if ($tempVehicle->driver_passenger_booking_id && isset($passengerIdMap[$tempVehicle->driver_passenger_booking_id])) {
                    $permanentDriverId = $passengerIdMap[$tempVehicle->driver_passenger_booking_id];
                }

                $permanentVehicle = PermanentBookedVehicle::create([
                    'booking_id' => $bookingId,
                    'vehicle_type' => $tempVehicle->vehicle_type,
                    'plate_no' => $tempVehicle->plate_no,
                    'length' => $tempVehicle->length,
                    'weight' => $tempVehicle->weight,
                    'fare' => $tempVehicle->fare,
                    'driver_passenger_booking_id' => $permanentDriverId,
                    'created_by' => $tempVehicle->created_by,
                    'expires_at' => null,
                ]);

                // Permanently delete from temporary table
                $tempVehicle->forceDelete();
                \Log::info("Transferred vehicle ID: {$tempVehicle->booked_vehicle_id} to permanent storage");

                $transferredVehicles[] = $permanentVehicle;
            } catch (\Exception $e) {
                \Log::error("Failed to transfer vehicle ID: {$tempVehicle->booked_vehicle_id}. Error: " . $e->getMessage());
            }
        }

        return $transferredVehicles;
    }

    private function normalizeKeys(array $data): array
    {
        $map = [
            'bookingId' => 'booking_id',
            'totalFare' => 'total_fare',
            'totalDiscount' => 'total_discount',
            'grandTotal' => 'grand_total',
            'totalAdminFee' => 'total_admin_fee',
            'paymentMethod' => 'payment_method',
            'referenceNumber' => 'reference_number',
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $data) && !array_key_exists($to, $data)) {
                $data[$to] = $data[$from];
            }
        }

        return $data;
    }

    /**
     * Generate unique booking number with incremental count
     * Format: {YEAR_HEX}{MONTH}-{COUNT}
     * Example: 7EA5-00001 (2026, May, 1st booking)
     */
    private function generateBookingNumber(): string
    {
        // Get current year and month
        $year = now()->year;
        $month = now()->month;
        
        // Convert year to hex (uppercase)
        $yearHex = strtoupper(dechex($year));
        
        // Generate prefix: {YEAR_HEX}{MONTH}
        $prefix = $yearHex . $month;
        
        // Get the last booking number with this prefix (already in transaction from execute())
        $lastBooking = Booking::where('booking_number', 'LIKE', $prefix . '-%')
            ->orderBy('booking_number', 'desc')
            ->lockForUpdate()
            ->first();
        
        // Extract count and increment
        $count = 1;
        if ($lastBooking) {
            $parts = explode('-', $lastBooking->booking_number);
            if (isset($parts[1])) {
                $count = (int)$parts[1] + 1;
            }
        }
        
        // Format count as 5-digit zero-padded
        $countFormatted = str_pad($count, 5, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$countFormatted}";
    }
}

