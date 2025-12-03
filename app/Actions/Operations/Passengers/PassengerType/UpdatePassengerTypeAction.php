<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'type' => 'nullable|string|max:255|unique:passenger_types,type,'
                    . $passengerType->p_id . ',p_id',
                'discount_id' => 'nullable|integer|exists:discounts,discount_id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $passengerType->update($validator->validated());

            return $this->success([
                'type' => $passengerType->fresh()->load('discount'),
            ], 'Passenger type updated successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to update passenger type: ' . $e->getMessage(), 500);
        }
    }
}
