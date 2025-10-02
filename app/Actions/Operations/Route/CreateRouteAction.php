<?php
// app/Actions/Operations/Route/CreateRouteAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Illuminate\Support\Facades\Validator;

class CreateRouteAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'origin' => 'required|string|max:100',
                'destination' => 'required|string|max:100|different:origin',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', $validator->errors()->toArray());
            }

            $existingRoute = Route::where('origin', $data['origin'])
                ->where('destination', $data['destination'])
                ->first();

            if ($existingRoute) {
                return $this->error('Route already exists.');
            }

            // Create route
            $route = Route::create($data);

            return $this->success([
                'route' => $route,
            ], 'Route created successfully', 201);

        } catch (\Exception $e) {
            return $this->error('Failed to create route.', $e->getMessage());
        }
    }
}
