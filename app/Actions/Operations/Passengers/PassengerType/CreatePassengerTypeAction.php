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
            'type' => 'required|string|max:255|unique:passenger_types,type',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed.', 422, $validator->errors()->toArray());
        }

        $type = PassengerType::create($data);

        return $this->success([
            'type' => $type,
        ], 'Passenger type created successfully');
    }
}
