<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Illuminate\Support\Facades\Validator;

class UpdateVehicleGroupAction extends Action
{
    public function execute(VehicleGroup $vehicleGroup, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'label' => 'sometimes|required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $vehicleGroup->update($data);

            return $this->success(['vehicleGroup' => $vehicleGroup->fresh()], 'Vehicle group updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update vehicle group.', 500, $e->getMessage());
        }
    }
}
