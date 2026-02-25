<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use Illuminate\Support\Facades\Validator;

class CreateVehicleRateAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $vehicleRate = VehicleRate::create($validated);

        return $this->success([
            'data' => $vehicleRate,
        ], 'Vehicle rate created successfully', 201);
    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'vehicle_id'     => 'required|integer|exists:vehicles,vehicle_id',
            'route_id'       => 'required|integer|exists:routes,route_id',
            'vehicle_rate'   => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'status'         => 'nullable|in:active,inactive',
        ])->validate();
    }
}