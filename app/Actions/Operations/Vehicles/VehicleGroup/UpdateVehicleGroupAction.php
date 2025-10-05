<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UpdateVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup, array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'label' => 'sometimes|required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Update vehicle group
            $vehicleGroup->update($data);

            return $this->success([
                'vehicleGroup' => $vehicleGroup->fresh(),
            ], 'Vehicle group updated successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to update vehicle group: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
