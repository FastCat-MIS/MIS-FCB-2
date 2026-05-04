<?php

namespace App\Actions\Teller\Payment;

use App\Actions\Action;
use App\Models\Teller\BookingPayment;
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
            'booking_id' => 'required|integer|min:1',
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

            // Log the serial number being used for transfer
        \Log::info("Processing payment with serial_no: {$validated['serial_no']}, booking_id: {$validated['booking_id']}");

        // DEBUG: Check if passenger exists before transfer
        $passengerCount = BookedPassenger::where('serial_no', $validated['serial_no'])->count();
        \Log::info("DEBUG: Found {$passengerCount} passengers with serial_no: {$validated['serial_no']}");

        // DEBUG: Check if vehicle exists before transfer
        $vehicleCount = BookedVehicle::where('serial_no', $validated['serial_no'])->count();
        \Log::info("DEBUG: Found {$vehicleCount} vehicles with serial_no: {$validated['serial_no']}");

            // Create payment
            $payment = BookingPayment::create($validated);

            // Transfer passengers from temporary to permanent tables
            $this->transferPassengersToPermanent($validated['serial_no'], $payment->booking_id);

            // Transfer vehicles from temporary to permanent tables
            $this->transferVehiclesToPermanent($validated['serial_no'], $payment->booking_id);

            // Load the transferred data for the response
            $payment->load(['bookedPassengers', 'bookedVehicles']);

            return $this->success([
                'payment' => $payment,
            ], 'Payment processed successfully. Passengers and vehicles transferred to permanent storage.', 201);
        });
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

        $transferredPassengers = [];

        foreach ($temporaryPassengers as $tempPassenger) {
            try {
                $permanentPassenger = PermanentBookedPassenger::create([
                    'serial_no' => $tempPassenger->serial_no,
                    'booking_id' => $bookingId,
                    'schedule_booking_id' => $tempPassenger->schedule_booking_id,
                    'is_return_trip' => $tempPassenger->is_return_trip,
                    'travel_date' => $tempPassenger->travel_date,
                    'schedule_id' => $tempPassenger->schedule_id,
                    'schedule_snapshot' => $tempPassenger->schedule_snapshot,
                    'route_id' => $tempPassenger->route_id,
                    'route_snapshot' => $tempPassenger->route_snapshot,
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
                    'expires_at' => null, // Remove expiration for permanent records
                ]);

                // Delete from temporary table
                $tempPassenger->delete();
                \Log::info("Transferred passenger ID: {$tempPassenger->booked_passenger_id} to permanent storage");

                // Add to transferred collection
                $transferredPassengers[] = $permanentPassenger;
            } catch (\Exception $e) {
                \Log::error("Failed to transfer passenger ID: {$tempPassenger->booked_passenger_id}. Error: " . $e->getMessage());
            }
        }

        return $transferredPassengers;
    }

    private function transferVehiclesToPermanent(string $serialNo, int $bookingId): array
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
                $permanentVehicle = PermanentBookedVehicle::create([
                    'serial_no' => $tempVehicle->serial_no,
                    'booking_id' => $bookingId,
                    'schedule_booking_id' => $tempVehicle->schedule_booking_id,
                    'is_return_trip' => $tempVehicle->is_return_trip,
                    'travel_date' => $tempVehicle->travel_date,
                    'schedule_id' => $tempVehicle->schedule_id,
                    'schedule_snapshot' => $tempVehicle->schedule_snapshot,
                    'route_id' => $tempVehicle->route_id,
                    'route_snapshot' => $tempVehicle->route_snapshot,
                    'vehicle_type' => $tempVehicle->vehicle_type,
                    'plate_no' => $tempVehicle->plate_no,
                    'length' => $tempVehicle->length,
                    'weight' => $tempVehicle->weight,
                    'fare' => $tempVehicle->fare,
                    'driver_passenger_booking_id' => $tempVehicle->driver_passenger_booking_id,
                    'institutional_account_id' => $tempVehicle->institutional_account_id,
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

