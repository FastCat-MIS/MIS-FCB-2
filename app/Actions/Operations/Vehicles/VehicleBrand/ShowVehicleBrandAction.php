<?php

namespace App\Actions\Operations\Vehicles\VehicleBrand;

use App\Actions\Action;
use App\Models\Operations\VehicleBrand;

class ShowVehicleBrandAction extends Action
{
    public function execute(VehicleBrand $vehicleBrand)
    {
        try {
            $vehicleBrand->load('type');

            return $this->success([
                'vehicleBrand' => $vehicleBrand,
            ], 'Vehicle brand retrieved successfully.');
        } catch (\Throwable $e) {
            return $this->error(
                'Failed to retrieve vehicle brand',
                500,
                $e->getMessage()
            );
        }
    }
}
