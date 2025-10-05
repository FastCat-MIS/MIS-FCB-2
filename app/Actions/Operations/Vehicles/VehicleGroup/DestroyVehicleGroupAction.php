<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Exception;

class DestroyVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup)
    {
        try {
            $vehicleGroup->delete();

            return $this->success([], 'Vehicle group deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new Exception('Failed to delete vehicle group: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
