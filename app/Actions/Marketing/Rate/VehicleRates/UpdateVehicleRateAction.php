<?php

namespace App\Actions\Marketing\Rate\VehicleRates;

use App\Actions\Action;
use App\Models\Marketing\VehicleRate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateVehicleRateAction extends Action
{
    public function execute(int $vehicleRateId, array $data)
    {

        try {
            $validated = $this->validate($data);

            $vehicleRate = VehicleRate::findOrFail($vehicleRateId);

            $vehicleRate->update($validated);

            return $this->success([
                'vehicleRate' => $vehicleRate
            ], 'Vehicle Rate updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("Vehicle Rate with ID {$vehicleRateId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to update vehicle rate.');
        }
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