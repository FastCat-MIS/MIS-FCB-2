<?php

namespace App\Actions\Operations\Vehicles;

use App\Actions\Action;
use App\Models\Operations\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateVehicleAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'vehicle_type' => 'required|integer|min:1',

            'vehicle_classes' => 'required|array|min:1',
            'vehicle_classes.*.vehicle_class' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($data) {

            $createdVehicles = [];

            foreach ($data['vehicle_classes'] as $class) {

                $createdVehicles[] = Vehicle::create([
                    'vehicle_type' => $data['vehicle_type'],
                    'vehicle_class' => $class['vehicle_class'],
                ]);
            }

            return $this->success([
                'data' => $createdVehicles,
            ], 'Vehicle(s) created successfully', 201);
        });
    }
}