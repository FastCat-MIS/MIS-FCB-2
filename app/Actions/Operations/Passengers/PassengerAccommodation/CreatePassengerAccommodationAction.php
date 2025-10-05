<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/CreatePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePassengerAccommodationAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'accomodation_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $accommodation = PassengerAccommodation::create($data);

        return $this->success([
            'passengerAccommodation' => $accommodation,
        ], 'Passenger Accommodation created successfully', 201);
    }
}
