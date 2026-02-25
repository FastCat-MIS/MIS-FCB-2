<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use RuntimeException;

class GetVehicleRatesAction extends Action
{
   public function execute()
    {
       try {
            $vehicleRates = VehicleRate::get();

            return $this->success([
                'vehicleRates' => $vehicleRates,
            ], 'Vehicles rates retrieved successfully');                        
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve vehicle rates.');   
        }    
    }
}