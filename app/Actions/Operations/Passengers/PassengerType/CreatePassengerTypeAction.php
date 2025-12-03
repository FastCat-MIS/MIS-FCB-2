<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;
use Illuminate\Support\Facades\Validator;

class CreatePassengerTypeAction extends Action
{
    public function execute(array $data)
    {
        $validated = Validator::make($data, [
            'type' => 'required|string|max:255|unique:passenger_types,type',
            'discount_id' => 'nullable|integer|exists:discounts,discount_id',
        ])->validate();

        $type = PassengerType::create($validated);

        return $this->success([
            'type' => $type->load('discount'),
        ], 'Passenger type created successfully', 201);
    }
}
