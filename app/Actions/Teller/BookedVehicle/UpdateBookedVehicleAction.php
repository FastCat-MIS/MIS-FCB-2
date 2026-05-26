<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateBookedVehicleAction extends Action
{
    public function execute(int $bookedVehicleId, array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            'booking_id' => 'sometimes|nullable|integer|min:1',
            'travel_date' => 'sometimes|required|date',
            'schedule_id' => 'sometimes|required|integer|min:1',
            'schedule_snapshot' => 'sometimes|required|date_format:H:i:s',
            'route_id' => 'sometimes|required|integer|min:1',
            'route_snapshot' => 'sometimes|required|string|max:255',
            'vehicle_type' => 'sometimes|required|string|max:50',
            'plate_no' => 'sometimes|required|string|max:20',
            'length' => 'sometimes|nullable|numeric|min:0',
            'weight' => 'sometimes|nullable|numeric|min:0',
            'fare' => 'sometimes|required|numeric|min:0',
            'driver_passenger_booking_id' => 'sometimes|nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $bookedVehicle = BookedVehicle::findOrFail($bookedVehicleId);
            $bookedVehicle->update($validator->validated());

            return $this->success([
                'booked_vehicle' => $bookedVehicle->fresh(),
            ], 'Booked vehicle updated successfully');
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Booked vehicle with ID {$bookedVehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to update booked vehicle.');
        }
    }

    private function normalizeKeys(array $data): array
    {
        $map = [
            'bookingId' => 'booking_id',
            'scheduleBookingId' => 'schedule_booking_id',
            'isReturnTrip' => 'is_return_trip',
            'travelDate' => 'travel_date',
            'scheduleId' => 'schedule_id',
            'scheduleSnapshot' => 'schedule_snapshot',
            'routeId' => 'route_id',
            'routeSnapshot' => 'route_snapshot',
            'vehicleType' => 'vehicle_type',
            'plateNo' => 'plate_no',
            'driverPassengerBookingId' => 'driver_passenger_booking_id',
            'institutionalAccountId' => 'institutional_account_id',
        ];

        foreach ($map as $from => $to) {
            if (array_key_exists($from, $data) && !array_key_exists($to, $data)) {
                $data[$to] = $data[$from];
            }
        }

        return $data;
    }
}

