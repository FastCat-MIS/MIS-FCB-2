<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use Illuminate\Support\Facades\Validator;
use App\Models\Operations\VehicleType;

class UpdateVehicleTypeAction extends Action
{
    public function execute(VehicleType $vehicleType, array $data)
    {
        $validator = Validator::make($data, [
            'group_id'  => 'sometimes|exists:vehicle_groups,group_id',
            'label'     => 'sometimes|string|max:255',
            'type_code' => 'sometimes|string|max:255|unique:vehicle_types,type_code,' . $vehicleType->type_id . ',type_id',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                422,
                $validator->errors()
            );
        }

        try {
            $vehicleType->update($data);
            return $this->success($vehicleType, 'Vehicle type updated successfully.');
        } catch (\Throwable $e) {
            return $this->error(
                'Failed to update vehicle type',
                500,
                $e->getMessage()
            );
        }
    }
}
