<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class StoreVehicleGroupAction extends Action
{
    public function execute(array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'label' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Create vehicle group
            $group = VehicleGroup::create($data);

            return $this->success([
                'vehicleGroup' => $group,
            ], 'Vehicle group created successfully.', 201);
        } catch (\Throwable $e) {
            throw new Exception('Failed to create vehicle group: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
