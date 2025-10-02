<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/GetPassengerAccommodationsAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;

class GetPassengerAccommodationsAction extends Action
{
    public function execute()
    {
        try {
            $accommodations = PassengerAccommodation::all();

            return $this->success([
                'passengerAccommodations' => $accommodations,
            ], 'Passenger Accommodations retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve accommodations.', 500, $e->getMessage());
        }
    }
}
