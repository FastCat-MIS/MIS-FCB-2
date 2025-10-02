<?php

namespace App\Actions\Operations\Vehicles\VehicleType;

use App\Actions\Action;
use App\Models\Operations\VehicleType;
use Illuminate\Support\Facades\Validator;

class StoreVehicleTypeAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'label' => 'required|string|max:255',
                'group_id' => 'required|exists:vehicle_groups,id',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $type = VehicleType::create($data);

            return $this->success(['vehicleType' => $type], 'Vehicle type created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create vehicle type.', 500, $e->getMessage());
        }
    }
}
