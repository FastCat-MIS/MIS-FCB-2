<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateBookedPassengerAction extends Action
{
    public function execute(BookedPassenger $bookedPassenger, array $data)
    {
        $validator = Validator::make($data, [
            'booking_id' => 'sometimes|required|exists:bookings,booking_id',
            'fullname' => 'sometimes|required|string|max:255',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'amount' => 'sometimes|required|numeric|min:0',
            'vehicle_amount' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'accommodation' => 'nullable|string|max:50',
            'gender' => 'nullable|string|max:10',
            'seat' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $bookedPassenger->update($data);

        return $this->success(['booked_passenger' => $bookedPassenger->fresh()], 'Booked passenger updated successfully');
    }
}
