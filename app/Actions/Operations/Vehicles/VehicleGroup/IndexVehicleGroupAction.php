<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Exception;

class IndexVehicleGroupAction extends Action
{
    public function execute()
    {
        try {
            $groups = VehicleGroup::all();

            return $this->success([
                'vehicleGroups' => $groups,
            ], 'Vehicle groups retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve vehicle groups: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
