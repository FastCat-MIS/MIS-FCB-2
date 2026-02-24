<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use RuntimeException;

class GetVehicleAction extends Action
{
    public function execute(int $vehicleId) 
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId); 

            return $this->success([
                'vehicle' => $vehicle,
            ], 'Vehicle retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle with ID {$vehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve vehicle.');
        }
    }
}