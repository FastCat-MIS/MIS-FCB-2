<?php
// app/Actions/Operations/Passengers/PassengerAccommodation/DeletePassengerAccommodationAction.php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;

class DeletePassengerAccommodationAction extends Action
{
    public function execute(PassengerAccommodation $accommodation)
    {
        try {
            // Optional: check if linked to bookings
            $accommodation->delete();

            return $this->success([], 'Passenger Accommodation deleted successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to delete accommodation.', 500, $e->getMessage());
        }
    }
}
