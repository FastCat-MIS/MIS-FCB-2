<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookedVehicleAction extends Action
{
    public function execute(array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            'booking_id' => 'nullable|integer|min:1',
            'schedule_booking_id' => 'nullable|integer|min:1',
            'is_return_trip' => 'sometimes|boolean',
            'travel_date' => 'required|date',
            'schedule_id' => 'required|integer|min:1',
            'schedule_snapshot' => 'required|date_format:H:i:s',
            'route_id' => 'required|integer|min:1',
            'route_snapshot' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:50',
            'plate_no' => 'required|string|max:20',
            'length' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'fare' => 'required|numeric|min:0',
            'driver_passenger_booking_id' => 'nullable|integer|min:1',
            'institutional_account_id' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $bookedVehicle = BookedVehicle::create($validator->validated());

        return $this->success([
            'booked_vehicle' => $bookedVehicle,
        ], 'Booked vehicle created successfully', 201);
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

