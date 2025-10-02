<?php

namespace App\Actions\Operations\Vehicles\VehicleGroup;

use App\Actions\Action;
use App\Models\Operations\VehicleGroup;
use Illuminate\Support\Facades\Validator;

class StoreVehicleGroupAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'label' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $group = VehicleGroup::create($data);

            return $this->success(['vehicleGroup' => $group], 'Vehicle group created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create vehicle group.', 500, $e->getMessage());
        }
    }
}
