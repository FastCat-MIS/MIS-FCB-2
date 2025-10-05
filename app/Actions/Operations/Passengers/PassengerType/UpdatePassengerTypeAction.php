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
            // Validate input
            $validator = Validator::make($data, [
                'type' => 'required|string|max:255|unique:passenger_types,type,' . $passengerType->p_id . ',p_id',
            ]);

            if ($validator->fails()) {
                // Throw ValidationException for global handler
                throw new ValidationException($validator);
            }

            // Update model
            $passengerType->update($data);

            return $this->success([
                'type' => $passengerType->fresh(),
            ], 'Passenger type updated successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to update passenger type: ' . $e->getMessage(), 500);
        }
    }
}
