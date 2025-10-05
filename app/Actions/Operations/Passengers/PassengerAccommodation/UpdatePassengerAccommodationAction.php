<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/UpdatePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;

class UpdatePassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation, array $data)
    {
        $validator = Validator::make($data, [
            'accomodation_name' => 'sometimes|required|string|max:255',
        ]);

        $validator->validate(); // Let global handler catch ValidationException

        $accommodation->update($data);

        return $this->success([
            'passengerAccommodation' => $accommodation->fresh(),
        ], 'Passenger Accommodation updated successfully');
    }
}
