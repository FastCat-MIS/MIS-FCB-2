<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use RuntimeException;

class DeleteVehicleAction extends Action
{

    public function execute(int $vehicleId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId); 

            $vehicle->delete();

            return $this->success([], 'Vehicle deleted successfully', 204);        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle with ID {$vehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete vehicle.');
        }
    }
}