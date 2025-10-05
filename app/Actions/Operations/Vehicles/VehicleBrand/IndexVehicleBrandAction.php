<?php

namespace App\Actions\Operations\Vehicles\VehicleBrand;

use App\Actions\Action;
use App\Models\Operations\VehicleBrand;

class IndexVehicleBrandAction extends Action
{
    public function execute()
    {
        try {
            $brands = VehicleBrand::with('type')->get();

            return $this->success([
                'vehicleBrands' => $brands,
            ], 'Vehicle brands retrieved successfully.');
        } catch (\Throwable $e) {
            // Safe error handling: always integer code
            return $this->error(
                'Failed to retrieve vehicle brands',
                500,
                $e->getMessage()
            );
        }
    }
}
