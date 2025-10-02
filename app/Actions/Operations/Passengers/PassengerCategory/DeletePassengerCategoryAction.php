<?php

namespace App\Actions\Operations\Passengers\PassengerCategory;

use App\Actions\Action;
use App\Models\Operations\PassengerCategory;

class DeletePassengerCategoryAction extends Action
{
    public function execute(PassengerCategory $passengerCategory)
    {
        $passengerCategory->delete();

        return $this->success([], 'Passenger category deleted successfully.');
    }
}
