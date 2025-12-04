<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePassengerTypeAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'type' => 'required|string|max:255',
            'discount'  => 'required|numeric|min:0|max:1',
            'waived'    => 'required|boolean',
            'status'    => 'nullable|string|in:active,inactive',
        ]);

        $validator->validate();

        $passengerType = PassengerType::create($validator->validated());

        return $this->success([
            'passenger_type' => $passengerType,
        ], 'Passenger type created successfully');
    }
}
