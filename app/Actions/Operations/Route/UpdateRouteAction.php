<?php
// app/Actions/Operations/Route/UpdateRouteAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UpdateRouteAction extends Action
{
    public function execute(Route $route, array $data = [])
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'origin' => 'sometimes|required|string|max:100',
                'destination' => 'sometimes|required|string|max:100|different:origin',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Check if updated route would conflict with existing one
            if (isset($data['origin']) || isset($data['destination'])) {
                $origin = $data['origin'] ?? $route->origin;
                $destination = $data['destination'] ?? $route->destination;

                $existingRoute = Route::where('origin', $origin)
                    ->where('destination', $destination)
                    ->where('route_id', '!=', $route->route_id)
                    ->first();

                if ($existingRoute) {
                    throw new Exception('Route with these details already exists.', 409);
                }
            }

            // Update route
            $route->update($data);

            return $this->success([
                'route' => $route->fresh(),
            ], 'Route updated successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to update route: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
