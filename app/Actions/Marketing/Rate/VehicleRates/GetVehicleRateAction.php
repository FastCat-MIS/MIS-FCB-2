<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use RuntimeException;

class GetVehicleRateAction extends Action
{
    public function execute(int $vehicleRateId) 
    {
        try {
            $vehicleRate = VehicleRate::findOrFail($vehicleRateId); 

            return $this->success([
                'vehicleRate' => $vehicleRate,
            ], 'Vehicle Rate retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle Rate with ID {$vehicleRateId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve vehicle rate.');
        }
    }
}