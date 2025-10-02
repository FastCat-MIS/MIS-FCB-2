<?php

namespace App\Actions\Operations\Vehicles\VehicleBrand;

use App\Actions\Action;
use App\Models\Operations\VehicleBrand;
use Illuminate\Support\Facades\Validator;

class UpdateVehicleBrandAction extends Action
{
    public function execute(VehicleBrand $vehicleBrand, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'label' => 'sometimes|required|string|max:255',
                'type_id' => 'sometimes|required|exists:vehicle_types,id',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $vehicleBrand->update($data);

            return $this->success(['vehicleBrand' => $vehicleBrand->fresh()->load('type')], 'Vehicle brand updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update vehicle brand.', 500, $e->getMessage());
        }
    }
}
