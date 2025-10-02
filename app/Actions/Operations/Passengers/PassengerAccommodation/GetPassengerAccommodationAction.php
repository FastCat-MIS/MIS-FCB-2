<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/GetPassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;

class GetPassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation)
    {
        try {
            return $this->success([
                'passengerAccommodation' => $accommodation,
            ], 'Passenger Accommodation retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve accommodation.', 500, $e->getMessage());
        }
    }
}
