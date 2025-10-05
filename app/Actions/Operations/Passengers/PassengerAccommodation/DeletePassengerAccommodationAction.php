<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/DeletePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;

class DeletePassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation)
    {
        // Optional: add relationship checks here if needed
        $accommodation->delete();

        return $this->success([], 'Passenger Accommodation deleted successfully', 204);
    }
}
