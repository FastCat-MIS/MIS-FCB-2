<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use RuntimeException;

class DeleteVehicleRateAction extends Action
{

    public function execute(int $vehicleRateId)
    {
        try {
            $vehicleRate = VehicleRate::findOrFail($vehicleRateId); 

            $vehicleRate->delete();

            return $this->success([], 'Vehicle Rate deleted successfully', 204);        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle Ratewith ID {$vehicleRateId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete vehicle Rate.');
        }
    }
}