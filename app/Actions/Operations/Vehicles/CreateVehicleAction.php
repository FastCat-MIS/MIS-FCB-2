<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateVehicleAction extends Action
{
    public function execute(array $data)
        {
            $validator = Validator::make($data, [
            "vehicle_type" => 'required|integer|min:1',      
            "vehicle_class" => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $vehicle = Vehicle::create($data);

            return $this->success([
                'data' => $vehicle,
            ], 'Vehicle created successfully', 201);     
        }
}