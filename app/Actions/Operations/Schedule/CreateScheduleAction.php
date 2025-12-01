<?php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use App\Models\Operations\Vessel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class CreateScheduleAction extends Action
{
    public function execute(array $data)
    {
        try {
           $validator = Validator::make($data, [
                'departure_time' => 'required|date_format:H:i:s',
                'vessel_id'      => 'nullable|exists:vessels,id',
                'route_id'       => 'required|exists:routes,route_id',
                'status'         => 'sometimes|required|in:active,inactive',
            ]);


            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $schedule = Schedule::create([
                'departure_time' => $data['departure_time'],
                'vessel_id'      => $data['vessel_id'] ?? null,
                'route_id'       => $data['route_id'],
                'status'         => $data['status'] ?? 'active', // default to active
            ]);

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

            return $this->success(['schedule' => $result], 'Schedule created successfully.', 201);

        } catch (\Throwable $e) {
            throw new Exception('Failed to create schedule: ' . $e->getMessage(), 500);
        }
    }
}
