<?php

namespace App\Actions\Operations\BookedPassenger;

use App\Actions\Action;
use App\Models\Operations\BookedPassenger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBookedPassengerAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'booking_id' => 'required|exists:bookings,booking_id',
            'fullname' => 'required|string|max:255',
            'discount_id' => 'nullable|exists:discounts,discount_id',
            'amount' => 'required|numeric|min:0',
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

        $bookedPassenger = BookedPassenger::create($data);

        return $this->success(['booked_passenger' => $bookedPassenger], 'Booked passenger created successfully', 201);
    }
}
