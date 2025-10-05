<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class DeletePassengerTypeAction extends Action
{
    public function execute(PassengerType $passengerType)
    {
        try {
            $passengerType->delete();

            return $this->success([], 'Passenger type deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to delete passenger type: ' . $e->getMessage(), 500);
        }
    }
}
