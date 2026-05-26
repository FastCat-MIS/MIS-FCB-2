<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
use App\Models\Teller\TempBooking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookedPassengerAction extends Action
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
            'fullname' => 'required|string|max:255',
            'gender' => 'nullable|string|max:20',
            'passenger_type_id' => 'required|integer|min:1',
            'passenger_type_snapshot' => 'required|string|max:100',
            'passenger_category_id' => 'nullable|integer|min:1',
            'passenger_category_snapshot' => 'nullable|string|max:100',
            'seat_id' => 'nullable|integer|min:1',
            'seat_number_snapshot' => 'nullable|string|max:20',
            'agent_id' => 'nullable|integer|min:1',
            'fare' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_id' => 'nullable|integer|min:1',
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

        // Create passenger linked to temp_booking
        $passengerData = [
            'temp_booking_id' => $tempBooking->temp_booking_id,
            'serial_no' => $validated['serial_no'],
            'booking_id' => $validated['booking_id'] ?? null,
            'schedule_booking_id' => $validated['schedule_booking_id'] ?? null,
            'is_return_trip' => $validated['is_return_trip'] ?? false,
            'fullname' => $validated['fullname'],
            'gender' => $validated['gender'] ?? null,
            'passenger_type_id' => $validated['passenger_type_id'],
            'passenger_type_snapshot' => $validated['passenger_type_snapshot'],
            'passenger_category_id' => $validated['passenger_category_id'] ?? null,
            'passenger_category_snapshot' => $validated['passenger_category_snapshot'] ?? null,
            'seat_id' => $validated['seat_id'] ?? null,
            'seat_number_snapshot' => $validated['seat_number_snapshot'] ?? null,
            'agent_id' => $validated['agent_id'] ?? null,
            'fare' => $validated['fare'],
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'discount_id' => $validated['discount_id'] ?? null,
            'institutional_account_id' => $validated['institutional_account_id'] ?? null,
            'created_by' => $createdBy,
        ];

        $bookedPassenger = BookedPassenger::create($passengerData);

        return $this->success([
            'booked_passenger' => $bookedPassenger,
            'temp_booking' => $tempBooking,
        ], 'Booked passenger created successfully', 201);
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
            'passengerTypeId' => 'passenger_type_id',
            'passengerTypeSnapshot' => 'passenger_type_snapshot',
            'passengerCategoryId' => 'passenger_category_id',
            'passengerCategorySnapshot' => 'passenger_category_snapshot',
            'seatId' => 'seat_id',
            'seatNumberSnapshot' => 'seat_number_snapshot',
            'discountAmount' => 'discount_amount',
            'discountId' => 'discount_id',
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
