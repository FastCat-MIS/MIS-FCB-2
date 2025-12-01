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
            $schedule->load([
                'route.portA',
                'route.portB',
            ]);

            $vessel = \DB::table('vessels')->where('id', $schedule->vessel_id)->first();

            $result = [
                'sched_id'        => $schedule->sched_id,
                'departure_time'  => $schedule->departure_time,
                'vessel_id'       => $schedule->vessel_id,
                'vessel_name'     => $vessel->vessel_name ?? null,
                'route_id'        => $schedule->route_id,
                'route_name'      => $schedule->route?->route_name,
                'port_a_name'     => $schedule->route?->portA?->port_name,
                'port_b_name'     => $schedule->route?->portB?->port_name,
                'port_a_id'       => $schedule->route?->port_a_id,
                'port_b_id'       => $schedule->route?->port_b_id,
                'created_at'      => $schedule->created_at,
                'updated_at'      => $schedule->updated_at,
            ];

            return $this->success([
                'schedule' => $result,
            ], 'Schedule retrieved successfully.');

        } catch (\Throwable $e) {
            $code = is_numeric($e->getCode()) ? (int) $e->getCode() : 500;
            throw new Exception('Failed to retrieve schedule: ' . $e->getMessage(), $code);
        }
    }
}
