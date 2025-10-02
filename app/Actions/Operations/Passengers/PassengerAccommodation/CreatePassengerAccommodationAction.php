<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/CreatePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;

class CreatePassengerAccommodationAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'accomodation_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $accommodation = PassengerAccommodation::create($data);

            return $this->success([
                'passengerAccommodation' => $accommodation,
            ], 'Passenger Accommodation created successfully', 201);

        } catch (\Exception $e) {
            return $this->error('Failed to create accommodation.', 500, $e->getMessage());
        }
    }
}
