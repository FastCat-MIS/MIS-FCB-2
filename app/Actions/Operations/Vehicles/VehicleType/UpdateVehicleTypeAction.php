<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;
use Illuminate\Support\Facades\Validator;

class UpdateVehicleTypeAction extends Action
{
    public function execute(VehicleType $vehicleType, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'label' => 'sometimes|required|string|max:255',
                'group_id' => 'sometimes|required|exists:vehicle_groups,id',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $vehicleType->update($data);

            return $this->success(['vehicleType' => $vehicleType->fresh()->load('group')], 'Vehicle type updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update vehicle type.', 500, $e->getMessage());
        }
    }
}
