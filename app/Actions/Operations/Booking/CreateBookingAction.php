<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookingAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'sched_id' => 'nullable|exists:schedules,sched_id',
            'booking_number' => 'required|string|unique:bookings,booking_number',
            'booking_date' => 'required|date',
            'booking_source' => 'required|string|max:50',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'plate_number' => 'nullable|string|max:20',
            'is_connecting_trip' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data['is_connecting_trip'] = $data['is_connecting_trip'] ?? false;

        $booking = Booking::create($data);

        return $this->success(['booking' => $booking], 'Booking created successfully', 201);
    }
}
