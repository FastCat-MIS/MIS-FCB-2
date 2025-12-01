<?php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class CreateRateAction extends Action
{
    public function execute(array $data)
    {
        // Validate input
        $validator = Validator::make($data, [
            'route_id' => 'nullable|exists:routes,route_id',
            'seat_class' => 'required|string|max:50',
            'base_rate' => 'required|numeric|min:0',
            'effective_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive', // ✅ optional now
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Set default status to 'active' if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        // Ensure ONLY 1 active rate per route *if route_id is provided*
        if (
            isset($data['route_id']) &&
            $data['status'] === 'active'
        ) {
            $existing = Rate::where('route_id', $data['route_id'])
                ->where('status', 'active')
                ->first();

            if ($existing) {
                throw new RuntimeException('An active rate already exists for this route.', 409);
            }
        }

        $rate = Rate::create($data);

        return $this->success([
            'rate' => $rate->load('route'),
        ], 'Rate created successfully', 201);
    }
}
