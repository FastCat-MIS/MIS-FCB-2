<?php

namespace App\Actions\Teller\BookedVehicle;

use App\Actions\Action;
use App\Models\Teller\BookedVehicle;
use App\Models\Teller\TempBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookedVehicleAction extends Action
{
    public function execute(array $data)
    {
        $data = $this->normalizeKeys($data);

        $validator = Validator::make($data, [
            // Booking-level fields (for TempBooking)
            'serial_no' => 'required|string|max:50',
            'schedule_booking_id' => 'nullable|integer|min:1',
            'is_return_trip' => 'sometimes|boolean',
            'travel_date' => 'required|date',
            'schedule_id' => 'required|integer|min:1',
            'schedule_snapshot' => 'required|date_format:H:i:s',
            'route_id' => 'required|integer|min:1',
            'route_snapshot' => 'required|string|max:255',
            'vessel_snapshot' => 'nullable|string|max:255',
            'institutional_account_id' => 'nullable|integer|min:1',
            'institutional_account_snapshot' => 'nullable|string|max:255',
            
            // Vehicle-level fields
            'vehicle_type' => 'required|string|max:50',
            'plate_no' => 'nullable|string|max:20',
            'length' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'fare' => 'required|numeric|min:0',
            'driver_passenger_booking_id' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        
        // Auto-populate created_by from JWT token
        $createdBy = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');
        $validated['created_by'] = $createdBy;

        return DB::connection('teller_booking')->transaction(function () use ($validated, $createdBy) {
            $tempBooking = TempBooking::where('serial_no', $validated['serial_no'])->first();

            if ($tempBooking) {
                if ((string) $tempBooking->created_by !== (string) $createdBy) {
                    return $this->error('Unauthorized: this booking belongs to another teller', 403);
                }

                $updateData = [];
                if (isset($validated['schedule_booking_id'])) $updateData['schedule_booking_id'] = $validated['schedule_booking_id'];
                if (isset($validated['is_return_trip'])) $updateData['is_return_trip'] = $validated['is_return_trip'];
                if (isset($validated['travel_date'])) $updateData['travel_date'] = $validated['travel_date'];
                if (isset($validated['schedule_id'])) $updateData['schedule_id'] = $validated['schedule_id'];
                if (isset($validated['schedule_snapshot'])) $updateData['schedule_snapshot'] = $validated['schedule_snapshot'];
                if (isset($validated['route_id'])) $updateData['route_id'] = $validated['route_id'];
                if (isset($validated['route_snapshot'])) $updateData['route_snapshot'] = $validated['route_snapshot'];
                if (isset($validated['vessel_snapshot'])) $updateData['vessel_snapshot'] = $validated['vessel_snapshot'];
                if (isset($validated['institutional_account_id'])) $updateData['institutional_account_id'] = $validated['institutional_account_id'];
                if (isset($validated['institutional_account_snapshot'])) $updateData['institutional_account_snapshot'] = $validated['institutional_account_snapshot'];

                if (!empty($updateData)) {
                    $tempBooking->update($updateData);
                }
            } else {
                $tempBooking = TempBooking::create([
                    'serial_no' => $validated['serial_no'],
                    'schedule_booking_id' => $validated['schedule_booking_id'] ?? null,
                    'is_return_trip' => $validated['is_return_trip'] ?? false,
                    'travel_date' => $validated['travel_date'],
                    'schedule_id' => $validated['schedule_id'],
                    'schedule_snapshot' => $validated['schedule_snapshot'],
                    'route_id' => $validated['route_id'],
                    'route_snapshot' => $validated['route_snapshot'],
                    'vessel_snapshot' => $validated['vessel_snapshot'] ?? null,
                    'institutional_account_id' => $validated['institutional_account_id'] ?? null,
                    'institutional_account_snapshot' => $validated['institutional_account_snapshot'] ?? null,
                    'booking_origin' => 'teller',
                    'created_by' => $createdBy,
                ]);
            }

            $bookedVehicle = BookedVehicle::create([
                'temp_booking_id' => $tempBooking->temp_booking_id,
                'vehicle_type' => $validated['vehicle_type'],
                'plate_no' => $validated['plate_no'] ?? null,
                'length' => $validated['length'] ?? null,
                'weight' => $validated['weight'] ?? null,
                'fare' => $validated['fare'],
                'convenience_fee' => 25.00,
                'driver_passenger_booking_id' => $validated['driver_passenger_booking_id'] ?? null,
                'created_by' => $createdBy,
            ]);

            return $this->success([
                'booked_vehicle' => $bookedVehicle,
                'temp_booking' => $tempBooking,
            ], 'Booked vehicle created successfully', 201);
        });
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

