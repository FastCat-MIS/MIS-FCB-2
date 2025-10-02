<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;

class ShowVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup)
    {
        try {
            return $this->success(['vehicleGroup' => $vehicleGroup], 'Vehicle group retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve vehicle group.', 500, $e->getMessage());
        }
    }
}
