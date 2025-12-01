<?php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UpdateScheduleAction extends Action
{
    public function execute(Schedule $schedule, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'departure_time' => 'sometimes|required|date_format:H:i:s',
                'vessel_id'      => 'sometimes|nullable|exists:vessels,id',
                'route_id'       => 'sometimes|required|exists:routes,route_id',
                'status'         => 'sometimes|required|in:active,inactive',
            ]);


            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $schedule->update($data);
            $schedule->load(['route.portA', 'route.portB', 'vessel']);

            $result = [
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

            return $this->success(['schedule' => $result], 'Schedule updated successfully.');

        } catch (\Throwable $e) {
            throw new Exception('Failed to update schedule: ' . $e->getMessage(), 500);
        }
    }
}
