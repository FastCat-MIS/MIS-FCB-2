<?php
// app/Actions/Operations/Route/UpdateRouteAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Illuminate\Support\Facades\Validator;

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
                return $this->error('Validation failed.', $validator->errors()->toArray());
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
                    return $this->error('Route with these details already exists.');
                }
            }

            // Update route
            $route->update($data);

            return $this->success([
                'route' => $route->fresh(),
            ], 'Route updated successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to update route.', $e->getMessage());
        }
    }
}
