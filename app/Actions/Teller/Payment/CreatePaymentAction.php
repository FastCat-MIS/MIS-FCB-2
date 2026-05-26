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

            // Transfer temp_booking to permanent booking
            $booking = $this->transferBookingToPermanent($tempBooking, $createdBy);
            
            \Log::info("Created permanent booking with ID: {$booking->booking_id}");

            // Transfer passengers from temporary to permanent tables and get ID mapping
            $passengerIdMap = $this->transferPassengersToPermanent($validated['serial_no'], $booking->booking_id);

            // Transfer vehicles from temporary to permanent tables with passenger ID mapping
            $this->transferVehiclesToPermanent($validated['serial_no'], $booking->booking_id, $passengerIdMap);

            // Create payment linked to the booking
            $paymentData = [
                'booking_id' => $booking->booking_id,
                'total_fare' => $validated['total_fare'],
                'total_discount' => $validated['total_discount'],
                'grand_total' => $validated['grand_total'],
                'total_admin_fee' => $validated['total_admin_fee'],
                'payment_method' => $validated['payment_method'],
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

    private function transferBookingToPermanent(TempBooking $tempBooking, int $createdBy): Booking
    {
        // Create permanent booking
        $booking = Booking::create([
            'travel_date' => $tempBooking->travel_date,
            'schedule_id' => $tempBooking->schedule_id,
            'schedule_snapshot' => $tempBooking->schedule_snapshot,
            'route_id' => $tempBooking->route_id,
            'route_snapshot' => $tempBooking->route_snapshot,
            'origin_port_snapshot' => $tempBooking->origin_port_snapshot,
            'destination_port_snapshot' => $tempBooking->destination_port_snapshot,
            'vessel_snapshot' => $tempBooking->vessel_snapshot,
            'created_by' => $createdBy,
        ]);

        // Delete temp booking
        $tempBooking->delete();
        
        \Log::info("Transferred temp_booking ID: {$tempBooking->temp_booking_id} to permanent booking ID: {$booking->booking_id}");

        return $booking;
    }

    private function transferPassengersToPermanent(string $serialNo, int $bookingId): array
    {
        $temporaryPassengers = BookedPassenger::where('serial_no', $serialNo)->get();

        // Log for debugging
        \Log::info("Transferring passengers with serial_no: {$serialNo}, found: " . $temporaryPassengers->count() . " records");

        if ($temporaryPassengers->isEmpty()) {
            \Log::warning("No passengers found with serial_no: {$serialNo} for transfer");
            return [];
        }

        $idMapping = []; // Map temp ID to permanent ID

        foreach ($temporaryPassengers as $tempPassenger) {
            try {
                $permanentPassenger = PermanentBookedPassenger::create([
                    'booking_id' => $bookingId,
                    'serial_no' => $tempPassenger->serial_no,
                    'schedule_booking_id' => $tempPassenger->schedule_booking_id,
                    'is_return_trip' => $tempPassenger->is_return_trip,
                    'fullname' => $tempPassenger->fullname,
                    'gender' => $tempPassenger->gender,
                    'passenger_type_id' => $tempPassenger->passenger_type_id,
                    'passenger_type_snapshot' => $tempPassenger->passenger_type_snapshot,
                    'passenger_category_id' => $tempPassenger->passenger_category_id,
                    'passenger_category_snapshot' => $tempPassenger->passenger_category_snapshot,
                    'seat_id' => $tempPassenger->seat_id,
                    'seat_number_snapshot' => $tempPassenger->seat_number_snapshot,
                    'agent_id' => $tempPassenger->agent_id,
                    'fare' => $tempPassenger->fare,
                    'discount_amount' => $tempPassenger->discount_amount,
                    'discount_id' => $tempPassenger->discount_id,
                    'institutional_account_id' => $tempPassenger->institutional_account_id,
                    'created_by' => $tempPassenger->created_by,
                    'expires_at' => null, // Remove expiration for permanent records
                ]);

                // Map temp ID to permanent ID
                $idMapping[$tempPassenger->booked_passenger_id] = $permanentPassenger->booked_passenger_id;

                // Delete from temporary table
                $tempPassenger->delete();
                \Log::info("Transferred passenger ID: {$tempPassenger->booked_passenger_id} to permanent storage with new ID: {$permanentPassenger->booked_passenger_id}");
            } catch (\Exception $e) {
                \Log::error("Failed to transfer passenger ID: {$tempPassenger->booked_passenger_id}. Error: " . $e->getMessage());
            }
        }

        return $idMapping;
    }

    private function transferVehiclesToPermanent(string $serialNo, int $bookingId, array $passengerIdMap = []): array
    {
        $temporaryVehicles = BookedVehicle::where('serial_no', $serialNo)->get();

        // Log for debugging
        \Log::info("Transferring vehicles with serial_no: {$serialNo}, found: " . $temporaryVehicles->count() . " records");

        if ($temporaryVehicles->isEmpty()) {
            \Log::warning("No vehicles found with serial_no: {$serialNo} for transfer");
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
                    'serial_no' => $tempVehicle->serial_no,
                    'schedule_booking_id' => $tempVehicle->schedule_booking_id,
                    'is_return_trip' => $tempVehicle->is_return_trip,
                    'vehicle_type' => $tempVehicle->vehicle_type,
                    'plate_no' => $tempVehicle->plate_no,
                    'length' => $tempVehicle->length,
                    'weight' => $tempVehicle->weight,
                    'fare' => $tempVehicle->fare,
                    'driver_passenger_booking_id' => $permanentDriverId, // Use mapped permanent ID
                    'institutional_account_id' => $tempVehicle->institutional_account_id,
                    'created_by' => $tempVehicle->created_by,
                    'expires_at' => null, // Remove expiration for permanent records
                ]);

                // Delete from temporary table
                $tempVehicle->delete();
                \Log::info("Transferred vehicle ID: {$tempVehicle->booked_vehicle_id} to permanent storage");

                // Add to transferred collection
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
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $data) && !array_key_exists($to, $data)) {
                $data[$to] = $data[$from];
            }
        }

        return $data;
    }
}

