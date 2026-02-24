<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateVehicleAction extends Action
{
    public function execute(int $vehicleId, array $data)
    {
        $validator = Validator::make($data, [
            "vehicle_type" => 'required|integer|min:1',
            'vehicle_class' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $vehicle = Vehicle::findOrFail($vehicleId);

            $vehicle->update($validator->validated());

            return $this->success([
                'vehicle' => $vehicle
            ], 'Vehicle updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle with ID {$vehicleId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to update vehicle.');
        }
    }
}