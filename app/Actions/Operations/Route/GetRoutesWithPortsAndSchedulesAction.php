<?php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Exception;

class GetRoutesWithPortsAndSchedulesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $routes = Route::with(['portA', 'portB', 'schedules'])->get();

            $result = $routes->map(function ($route) {
                return [
                    'route_id' => $route->route_id,
                    'route_name' => $route->routeName,
                    'portA' => [
                        'port_id' => $route->portA?->port_id,
                        'port_name' => $route->portA?->port_name,
                        'schedules' => $route->schedules->map(function ($sched) {
                            return [
                                'sched_id' => $sched->sched_id,
                                'departure_time' => $sched->departure_time,
                                'vessel' => $sched->vessel,
                            ];
                        }),
                    ],
                    'portB' => [
                        'port_id' => $route->portB?->port_id,
                        'port_name' => $route->portB?->port_name,
                        'schedules' => [], // Add schedules from port B if needed
                    ],
                ];
            });

            return $this->success(['routes' => $result], 'Routes with ports and schedules retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to retrieve routes with ports and schedules: ' . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }
    }
}
