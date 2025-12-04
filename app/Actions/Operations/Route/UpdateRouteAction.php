<?php

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
            $validator = Validator::make($data, [
                'port_a_id' => 'nullable|integer|exists:ports,port_id',
                'port_b_id' => 'nullable|integer|exists:ports,port_id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $portA = $data['port_a_id'] ?? $route->port_a_id;
            $portB = $data['port_b_id'] ?? $route->port_b_id;

            if (!empty($portA) && !empty($portB)) {

                if ($portA == $portB) {
                    throw new Exception("Port A and Port B cannot be the same.", 422);
                }

                $existingRoute = Route::where('port_a_id', $portA)
                    ->where('port_b_id', $portB)
                    ->where('route_id', '!=', $route->route_id)
                    ->first();

                if ($existingRoute) {
                    throw new Exception('Another route already exists for these ports.', 409);
                }
            }

            $route->update(array_filter([
                'port_a_id' => $data['port_a_id'] ?? null,
                'port_b_id' => $data['port_b_id'] ?? null,
            ], fn($v) => !is_null($v)));

            return $this->success([
                'route' => $route->fresh(),
            ], 'Route updated successfully.');

        } catch (\Throwable $e) {
            throw new Exception('Failed to update route: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
