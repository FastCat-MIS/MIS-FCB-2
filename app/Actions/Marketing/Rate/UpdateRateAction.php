<?php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UpdateRateAction extends Action
{
    public function execute(Rate $rate, array $data)
    {
        $validator = Validator::make($data, [
            'route_id' => 'nullable|exists:routes,route_id',
            'seat_class' => 'sometimes|required|string|max:50',
            'base_rate' => 'sometimes|required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Determine route_id to use for active check
        $routeId = $data['route_id'] ?? $rate->route_id;

        // If activating this rate, check for existing active rate
        if (isset($data['status']) && $data['status'] === 'active') {
            $existingActive = Rate::where('route_id', $routeId)
                ->where('status', 'active')
                ->where('rate_id', '!=', $rate->rate_id)
                ->first();

            if ($existingActive) {
                throw new RuntimeException('An active rate already exists for this route.', 409);
            }
        }

        // Update the rate
        $rate->update($data);

        // Return updated rate with route relation
        return $this->success([
            'rate' => $rate->fresh()->load('route'),
        ], 'Rate updated successfully');
    }
}
