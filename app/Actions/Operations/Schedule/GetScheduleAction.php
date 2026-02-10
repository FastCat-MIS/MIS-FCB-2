<?php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Exception;

class GetScheduleAction extends Action
{
    public function execute(Schedule $schedule)
    {
        try {
            $schedule->load(['port.route', 'vessel']);

            return $this->success([
                'schedule' => [
                    'sched_id'       => $schedule->sched_id,
                    'departure_time' => $schedule->departure_time,
                    'vessel'         => $schedule->vessel ? [
                        'id'   => $schedule->vessel->id,
                        'name' => $schedule->vessel->vessel_name,
                    ] : null,
                    'port' => $schedule->port ? [
                        'id'   => $schedule->port->port_id,
                        'name' => $schedule->port->port_name,
                        'route' => $schedule->port->route ? [
                            'id'   => $schedule->port->route->route_id,
                            'name' => $schedule->port->route->route_name,
                        ] : null,
                    ] : null,
                    'status'     => $schedule->status,
                    'created_at' => $schedule->created_at,
                    'updated_at' => $schedule->updated_at,
                    'visibility' => $schedule->visibility,
                ]
            ], 'Schedule retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve schedule: ' . $e->getMessage(), 500);
        }
    }
}
