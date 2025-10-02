<?php

namespace App\Actions\Operations\Vehicles\VehicleBrand;

use App\Actions\Action;
use App\Models\Operations\VehicleBrand;

class DestroyVehicleBrandAction extends Action
{
    public function execute(VehicleBrand $vehicleBrand)
    {
        try {
            $vehicleBrand->delete();
            return $this->success([], 'Vehicle brand deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete vehicle brand.', 500, $e->getMessage());
        }
    }
}
