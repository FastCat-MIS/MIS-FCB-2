<?php

namespace App\Actions\Operations\Booking;

use App\Actions\Action;
use App\Models\Operations\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateBookingAction extends Action
{
    public function execute(Booking $booking, array $data)
    {
        $validator = Validator::make($data, [
            'sched_id' => 'nullable|exists:schedules,sched_id',
            'booking_number' => 'sometimes|required|string|unique:bookings,booking_number,' . $booking->booking_id . ',booking_id',
            'booking_date' => 'sometimes|required|date',
            'booking_source' => 'sometimes|required|string|max:50',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'plate_number' => 'nullable|string|max:20',
            'is_connecting_trip' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $booking->update($data);

        return $this->success(['booking' => $booking->fresh()], 'Booking updated successfully');
    }
}
