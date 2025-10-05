<?php
// app/Actions/Operations/Route/CreateRouteAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateRouteAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'port_a' => 'required|string|max:100',
                'port_b' => 'required|string|max:100|different:port_a',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Check if route already exists
            $existingRoute = Route::where('port_a', $data['port_a'])
                ->where('port_b', $data['port_b'])
                ->first();

            if ($existingRoute) {
                throw new \Exception('Route already exists.', 409);
            }

            // Create route
            $route = Route::create($data);

            return $this->success([
                'route' => $route,
            ], 'Route created successfully.', 201);

        } catch (\Throwable $e) {
            throw new \Exception('Failed to create route: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
