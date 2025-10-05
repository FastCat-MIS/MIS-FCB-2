<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Exception;

class ShowVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup)
    {
        try {
            return $this->success([
                'vehicleGroup' => $vehicleGroup,
            ], 'Vehicle group retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve vehicle group: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
