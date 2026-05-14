<?php

namespace App\Actions\Teller\BookedPassenger;

use App\Actions\Action;
use App\Models\Teller\BookedPassenger;
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
        $validated['created_by'] = auth()->id() ?? \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->getClaim('user_id');

        $bookedPassenger = BookedPassenger::create($validated);

        return $this->success([
            'booked_passenger' => $bookedPassenger,
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
