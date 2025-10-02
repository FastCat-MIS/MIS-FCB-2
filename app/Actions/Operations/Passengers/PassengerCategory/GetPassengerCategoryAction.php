<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;

class GetPassengerCategoryAction extends Action
{
    public function execute(PassengerCategory $passengerCategory)
    {
        return $this->success([
            'category' => $passengerCategory
        ], 'Passenger category retrieved successfully.');
    }
}
