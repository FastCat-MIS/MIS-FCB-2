<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use App\Models\Teller\TempBooking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookedVehicleAction extends Action
{
    public function execute(array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            'serial_no' => 'required|string|max:50',
            'booking_id' => 'nullable|integer|min:1',
            'schedule_booking_id' => 'nullable|integer|min:1',
            'is_return_trip' => 'sometimes|boolean',
            'travel_date' => 'required|date',
            'schedule_id' => 'required|integer|min:1',
            'schedule_snapshot' => 'required|date_format:H:i:s',
            'route_id' => 'required|integer|min:1',
            'route_snapshot' => 'required|string|max:255',
            'origin_port_snapshot' => 'nullable|string|max:255',
            'destination_port_snapshot' => 'nullable|string|max:255',
            'vessel_snapshot' => 'nullable|string|max:255',
            'vehicle_type' => 'required|string|max:50',
            'plate_no' => 'nullable|string|max:20',
            'length' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'fare' => 'required|numeric|min:0',
            'driver_passenger_booking_id' => 'nullable|integer|min:1',
            'institutional_account_id' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        
        // Auto-populate created_by from JWT token
        $createdBy = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');
        $validated['created_by'] = $createdBy;

        // Find or create temp_booking
        $tempBooking = TempBooking::firstOrCreate(
            ['serial_no' => $validated['serial_no']],
            [
                'travel_date' => $validated['travel_date'],
                'schedule_id' => $validated['schedule_id'],
                'schedule_snapshot' => $validated['schedule_snapshot'],
                'route_id' => $validated['route_id'],
                'route_snapshot' => $validated['route_snapshot'],
                'origin_port_snapshot' => $validated['origin_port_snapshot'] ?? null,
                'destination_port_snapshot' => $validated['destination_port_snapshot'] ?? null,
                'vessel_snapshot' => $validated['vessel_snapshot'] ?? null,
                'created_by' => $createdBy,
            ]
        );

        // Create vehicle linked to temp_booking
        $vehicleData = [
            'temp_booking_id' => $tempBooking->temp_booking_id,
            'serial_no' => $validated['serial_no'],
            'booking_id' => $validated['booking_id'] ?? null,
            'schedule_booking_id' => $validated['schedule_booking_id'] ?? null,
            'is_return_trip' => $validated['is_return_trip'] ?? false,
            'vehicle_type' => $validated['vehicle_type'],
            'plate_no' => $validated['plate_no'] ?? null,
            'length' => $validated['length'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'fare' => $validated['fare'],
            'driver_passenger_booking_id' => $validated['driver_passenger_booking_id'] ?? null,
            'institutional_account_id' => $validated['institutional_account_id'] ?? null,
            'created_by' => $createdBy,
        ];

        $bookedVehicle = BookedVehicle::create($vehicleData);

        return $this->success([
            'booked_vehicle' => $bookedVehicle,
            'temp_booking' => $tempBooking,
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
            'originPortSnapshot' => 'origin_port_snapshot',
            'destinationPortSnapshot' => 'destination_port_snapshot',
            'vesselSnapshot' => 'vessel_snapshot',
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

