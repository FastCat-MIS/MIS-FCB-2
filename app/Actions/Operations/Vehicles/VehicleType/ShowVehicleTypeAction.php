<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;

class ShowVehicleTypeAction extends Action
{
    public function execute(VehicleType $vehicleType)
    {
        try {
            $vehicleType->load('group');
            return $this->success(['vehicleType' => $vehicleType], 'Vehicle type retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve vehicle type.', 500, $e->getMessage());
        }
    }
}
