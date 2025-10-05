<?php
// app/Actions/Marketing/Rate/UpdateRateAction.php

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
            'route_id' => 'sometimes|required|exists:routes,route_id',
            'base_fare' => 'sometimes|required|numeric|min:0',
            'peak_surcharge' => 'nullable|numeric|min:0',
            'holiday_surcharge' => 'nullable|numeric|min:0',
            'child_discount' => 'nullable|numeric|min:0|max:100',
            'senior_discount' => 'nullable|numeric|min:0|max:100',
            'currency' => 'sometimes|required|string|size:3',
            'effective_date' => 'sometimes|required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Check for conflicting active rate
        if (isset($data['status']) && $data['status'] === 'active') {
            $routeId = $data['route_id'] ?? $rate->route_id;

            $existingActiveRate = Rate::where('route_id', $routeId)
                ->where('status', 'active')
                ->where('rate_id', '!=', $rate->rate_id)
                ->first();

            if ($existingActiveRate) {
                throw new RuntimeException('An active rate already exists for this route.', 409);
            }
        }

        // Update
        $rate->update($data);

        return $this->success([
            'rate' => $rate->fresh()->load(['route']),
        ], 'Rate updated successfully');
    }
}
