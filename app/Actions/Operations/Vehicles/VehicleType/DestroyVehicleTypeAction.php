<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;

class DestroyVehicleTypeAction extends Action
{
    public function execute(VehicleType $vehicleType)
    {
        try {
            $vehicleType->delete();
            return $this->success(null, 'Vehicle type deleted successfully.', 204);
        } catch (\Throwable $e) {
            return $this->error(
                'Failed to delete vehicle type',
                500,
                $e->getMessage()
            );
        }
    }
}
