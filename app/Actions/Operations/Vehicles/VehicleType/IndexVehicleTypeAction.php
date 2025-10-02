<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;

class IndexVehicleTypeAction extends Action
{
    public function execute()
    {
        try {
            $types = VehicleType::with('group')->get();
            return $this->success(['vehicleTypes' => $types], 'Vehicle types retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve vehicle types.', 500, $e->getMessage());
        }
    }
}
