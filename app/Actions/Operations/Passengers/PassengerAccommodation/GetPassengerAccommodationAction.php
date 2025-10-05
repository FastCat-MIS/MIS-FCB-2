<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/GetPassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;

class GetPassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation)
    {
        return $this->success([
            'passengerAccommodation' => $accommodation,
        ], 'Passenger Accommodation retrieved successfully');
    }
}
