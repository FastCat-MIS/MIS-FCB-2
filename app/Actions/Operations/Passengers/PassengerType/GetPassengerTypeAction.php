<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class GetPassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType)
    {
        try {
            return $this->success([
                'type' => $passengerType,
            ], 'Passenger type retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve passenger type: ' . $e->getMessage(), 500);
        }
    }
}
