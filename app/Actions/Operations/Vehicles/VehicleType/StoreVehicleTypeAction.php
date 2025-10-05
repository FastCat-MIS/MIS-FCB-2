<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;
use Illuminate\Support\Facades\Validator;

class StoreVehicleTypeAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'group_id'  => 'required|exists:vehicle_groups,group_id',
            'label'     => 'required|string|max:255',
            'type_code' => 'required|string|max:255|unique:vehicle_types,type_code',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                422,
                $validator->errors()
            );
        }

        try {
            $vehicleType = VehicleType::create($data);
            return $this->success($vehicleType, 'Vehicle type created successfully.', 201);
        } catch (\Throwable $e) {
            return $this->error(
                'Failed to create vehicle type',
                500,
                $e->getMessage()
            );
        }
    }
}
