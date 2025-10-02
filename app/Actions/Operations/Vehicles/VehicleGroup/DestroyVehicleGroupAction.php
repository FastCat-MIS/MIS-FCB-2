<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;

class DestroyVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup)
    {
        try {
            $vehicleGroup->delete();
            return $this->success([], 'Vehicle group deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete vehicle group.', 500, $e->getMessage());
        }
    }
}
