<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class DeletePassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType)
    {
        $passengerType->delete();

        return $this->success([], 'Passenger type deleted successfully');
    }
}
