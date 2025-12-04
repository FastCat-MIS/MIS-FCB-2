<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;
use Illuminate\Support\Facades\Validator;

class CreatePassengerTypeAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'type'     => 'required|string|max:255',
            'discount' => 'required|numeric|min:0|max:1',
            'waived'   => 'nullable|boolean',
            'status'   => 'nullable|string|in:active,inactive',
        ]);

        $validator->validate();

        // Merge defaults for optional fields
        $validated = array_merge([
            'waived'  => false,
            'status'  => 'active',
        ], $validator->validated());

        $passengerType = PassengerType::create($validated);

        return $this->success([
            'passenger_type' => $passengerType,
        ], 'Passenger type created successfully');
    }
}
