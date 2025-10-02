<?php

namespace App\Actions\Operations\Passengers\PassengerType;

use App\Actions\Action;
use App\Models\Operations\PassengerType;

class GetPassengerTypesAction extends Action
{
    public function execute(array $data = [])
    {
        $types = PassengerType::all();

        return $this->success([
            'types' => $types,
        ], 'Passenger types retrieved successfully');
    }
}
