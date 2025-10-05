<?php

namespace App\Actions\Operations\Vehicles\VehicleBrand;

use App\Actions\Action;
use App\Models\Operations\VehicleBrand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreVehicleBrandAction extends Action
{
    public function execute(array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'label'   => 'required|string|max:255',
                'type_id' => 'required|exists:vehicle_types,type_id',
            ]);

            if ($validator->fails()) {
                return $this->error(
                    'Validation failed',
                    422,
                    $validator->errors()
                );
            }

            // Create vehicle brand
            $brand = VehicleBrand::create($data);

            return $this->success([
                'vehicleBrand' => $brand,
            ], 'Vehicle brand created successfully.', 201);
        } catch (\Throwable $e) {
            return $this->error(
                'Failed to create vehicle brand',
                500,
                $e->getMessage()
            );
        }
    }
}
