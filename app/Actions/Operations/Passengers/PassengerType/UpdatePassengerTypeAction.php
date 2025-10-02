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
            'type' => 'required|string|max:255|unique:passenger_types,type,' . $passengerType->p_id . ',p_id',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed.', 422, $validator->errors()->toArray());
        }

        $passengerType->update($data);

        return $this->success([
            'type' => $passengerType->fresh(),
        ], 'Passenger type updated successfully');
    }
}
