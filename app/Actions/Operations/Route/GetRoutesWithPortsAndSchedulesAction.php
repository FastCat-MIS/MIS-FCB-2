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
            // Eager load ports (portA, portB) and each port's schedules and vessels
            $routes = Route::with([
                'portA.schedules.vessel',
                'portB.schedules.vessel',
            ])->get();

            $result = $routes->map(function ($route) {
                return [
                    'route_id'   => $route->route_id,
                    'is_active' => $route->is_active,
                    'portA' => [
                        'port_id'   => $route->portA?->port_id,
                        'port_name' => $route->portA?->port_name,
                        'schedules' => $route->portA?->schedules->map(function ($sched) {
                            return [
                                'sched_id'       => $sched->sched_id,
                                'departure_time' => $sched->departure_time,
                                'vessel' => $sched->vessel ? [
                                    'id'   => $sched->vessel->id,
                                    'name' => $sched->vessel->vessel_name,
                                ] : null,
                                'status' => $sched->status,
                                'is_active' => $sched->is_active,
                                'visibility' => $sched->visibility,
                            ];
                        })->values(),
                    ],
                    'portB' => [
                        'port_id'   => $route->portB?->port_id,
                        'port_name' => $route->portB?->port_name,
                        'schedules' => $route->portB?->schedules->map(function ($sched) {
                            return [
                                'sched_id'       => $sched->sched_id,
                                'departure_time' => $sched->departure_time,
                                'vessel' => $sched->vessel ? [
                                    'id'   => $sched->vessel->id,
                                    'name' => $sched->vessel->vessel_name,
                                ] : null,
                                'status' => $sched->status,
                                'is_active' => $sched->is_active,
                                'visibility' => $sched->visibility,
                            ];
                        })->values(),
                    ],
                ];
            });

            return $this->success(
                ['routes' => $result],
                'Routes with ports and schedules retrieved successfully.'
            );

        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to retrieve routes with ports and schedules: ' . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }
    }
}
