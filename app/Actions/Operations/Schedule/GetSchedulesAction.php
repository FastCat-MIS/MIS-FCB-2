<?php
// app/Actions/Operations/Schedule/GetSchedulesAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Exception;

class GetSchedulesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            // ✅ Eager load route, and its ports
            $schedules = Schedule::with(['route.portA', 'route.portB'])->get();

            // Transform for API
            $result = $schedules->map(function ($schedule) {
                return [
                    'sched_id' => $schedule->sched_id,
                    'departure_time' => $schedule->departure_time,
                    'vessel' => $schedule->vessel,
                    'route_name' => $schedule->routeName,
                    'portA' => $schedule->portA?->port_name,
                    'portB' => $schedule->portB?->port_name,
                ];
            });

            return $this->success([
                'schedules' => $result,
            ], 'Schedules retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception(
                'Failed to retrieve schedules: ' . $e->getMessage(),
                $e->getCode() ?: 500
            );
        }
    }
}
