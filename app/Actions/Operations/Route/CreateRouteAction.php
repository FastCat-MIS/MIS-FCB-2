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
                'port_a_id' => 'required|integer|exists:ports,port_id',
                'port_b_id' => 'required|integer|different:port_a_id|exists:ports,port_id',
            ]);

            $validator->validate();

            // Check if route already exists
            $existingRoute = Route::where(function ($q) use ($data) {
                $q->where('port_a_id', $data['port_a_id'])
                  ->where('port_b_id', $data['port_b_id']);
            })
            ->orWhere(function ($q) use ($data) {
                $q->where('port_a_id', $data['port_b_id'])
                  ->where('port_b_id', $data['port_a_id']);
            })
            ->first();

            if ($existingRoute) {
                throw new \Exception('Route already exists.', 409);
            }

            // Create route
            $route = Route::create([
                'port_a_id' => $data['port_a_id'],
                'port_b_id' => $data['port_b_id'],
            ]);

            $route->load(['portA', 'portB']);

            return $this->success([
                'route' => $route,
            ], 'Route created successfully.', 201);

        } catch (\Throwable $e) {
            throw new \Exception(
                'Failed to create route: ' . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }
    }
}
