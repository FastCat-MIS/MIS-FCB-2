<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;
use Exception;

class ShowVehicleTypeAction extends Action
{
    public function execute(VehicleType $vehicleType)
    {
        try {
            $vehicleType->load('group');

            return $this->success([
                'vehicleType' => $vehicleType,
            ], 'Vehicle type retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve vehicle type: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
