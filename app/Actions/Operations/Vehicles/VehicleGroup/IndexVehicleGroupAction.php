<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;

class IndexVehicleGroupAction extends Action
{
    public function execute()
    {
        try {
            $groups = VehicleGroup::all();
            return $this->success(['vehicleGroups' => $groups], 'Vehicle groups retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve vehicle groups.', 500, $e->getMessage());
        }
    }
}
