<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class GetPassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType)
    {
        return $this->success([
            'type' => $passengerType,
        ], 'Passenger type retrieved successfully');
    }
}
