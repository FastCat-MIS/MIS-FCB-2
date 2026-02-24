<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use RuntimeException;

class GetVehiclesAction extends Action
{
   public function execute()
    {
       try {
            $vehicles = Vehicle::get();

            return $this->success([
                'vehicles' => $vehicles,
            ], 'Vehicles retrieved successfully');                        
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve vehicles.');   
        }    
    }
}