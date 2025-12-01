<?php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use App\Models\Operations\Vessel;
use Exception;

class GetSchedulesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $schedules = Schedule::with(['route.portA', 'route.portB', 'vessel'])->get();

            $result = $schedules->map(function ($schedule) {
                return [
                    'sched_id'       => $schedule->sched_id,
                    'departure_time' => $schedule->departure_time,
                    'vessel'         => $schedule->vessel ? [
                        'id'   => $schedule->vessel->id,
                        'name' => $schedule->vessel->vessel_name,
                    ] : null,
                    'route' => [
                        'id'     => $schedule->route_id,
                        'name'   => $schedule->route?->route_name,
                        'port_a' => $schedule->route?->portA?->port_name,
                        'port_b' => $schedule->route?->portB?->port_name,
                    ],
                    'created_at' => $schedule->created_at,
                    'updated_at' => $schedule->updated_at,
                    'status'     => $schedule->status,
                ];
            });

            return $this->success(['schedules' => $result], 'Schedules retrieved successfully.');

        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve schedules: ' . $e->getMessage(), 500);
        }
    }
}
