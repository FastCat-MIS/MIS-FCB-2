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
            $schedules = Schedule::with([
                'route.portA',
                'route.portB',
            ])->get();

            $vesselIds = $schedules->pluck('vessel_id')->filter()->unique()->toArray();
            $vessels = Vessel::whereIn('id', $vesselIds)->get()->keyBy('id');

            $result = $schedules->map(function ($schedule) use ($vessels) {
                $vessel = $vessels->get($schedule->vessel_id);

                return [
                    'sched_id'        => $schedule->sched_id,
                    'departure_time'  => $schedule->departure_time,
                    'vessel_id'       => $schedule->vessel_id,
                    'vessel_name'     => $vessel?->vessel_name,
                    'route_id'        => $schedule->route_id,
                    'route_name'      => $schedule->route?->route_name,
                    'port_a_name'     => $schedule->route?->portA?->port_name,
                    'port_b_name'     => $schedule->route?->portB?->port_name,
                    'created_at'      => $schedule->created_at,
                    'updated_at'      => $schedule->updated_at,
                ];
            });

            return $this->success([
                'schedules' => $result,
            ], 'Schedules retrieved successfully.');

        } catch (\Throwable $e) {
            $code = is_numeric($e->getCode()) ? (int) $e->getCode() : 500;
            throw new Exception('Failed to retrieve schedules: ' . $e->getMessage(), $code);
        }
    }
}
