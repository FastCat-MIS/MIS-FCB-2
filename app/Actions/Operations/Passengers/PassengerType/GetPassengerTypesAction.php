<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class GetPassengerTypesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $types = PassengerType::all();

            return $this->success([
                'types' => $types,
            ], 'Passenger types retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve passenger types: ' . $e->getMessage(), 500);
        }
    }
}
