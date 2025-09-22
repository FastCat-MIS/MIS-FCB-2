<?php
// app/Actions/Rate/CreateRateAction.php

namespace App\Actions\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use Illuminate\Support\Facades\Validator;

class CreateRateAction extends Action
{
    public function execute(array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'route_id' => 'required|exists:routes,route_id',
                'base_fare' => 'required|numeric|min:0',
                'peak_surcharge' => 'nullable|numeric|min:0',
                'holiday_surcharge' => 'nullable|numeric|min:0',
                'child_discount' => 'nullable|numeric|min:0|max:100',
                'senior_discount' => 'nullable|numeric|min:0|max:100',
                'currency' => 'required|string|size:3',
                'effective_date' => 'required|date',
                'expiry_date' => 'nullable|date|after:effective_date',
                'status' => 'required|in:active,inactive',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            // Check if active rate already exists for this route
            if ($data['status'] === 'active') {
                $existingActiveRate = Rate::where('route_id', $data['route_id'])
                    ->where('status', 'active')
                    ->first();

                if ($existingActiveRate) {
                    return $this->error('An active rate already exists for this route.', 409);
                }
            }

            // Create rate
            $rate = Rate::create($data);

            return $this->success([
                'rate' => $rate->load(['route']),
            ], 'Rate created successfully', 201);

        } catch (\Exception $e) {
            return $this->error('Failed to create rate.', 500, $e->getMessage());
        }
    }
}
