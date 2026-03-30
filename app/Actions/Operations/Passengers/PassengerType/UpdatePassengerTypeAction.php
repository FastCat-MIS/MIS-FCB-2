<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;
use Illuminate\Support\Facades\Validator;

class UpdatePassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType, array $data)
    {
        $validator = Validator::make($data, [
            'type' => 'nullable|string|max:255',
            'discount'  => 'nullable|numeric|min:0|max:1',
            'waived'    => 'nullable|boolean',
            'status'         => 'nullable|in:0,1,2,3',
        ]);

        $validator->validate();

        // Only update fields that were provided
        $passengerType->update($validator->validated());

        return $this->success([
            'passenger_type' => $passengerType->fresh(),
        ], 'Passenger type updated successfully');
    }
}
