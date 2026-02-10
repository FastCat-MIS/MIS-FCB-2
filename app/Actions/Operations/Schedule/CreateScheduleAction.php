<?php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
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
                'port_id'        => 'required|exists:ports,port_id',
                'status'         => 'sometimes|in:active,inactive',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 'active';
            }

            if (!isset($validated['visibility'])) {
                $validated['visibility'] = 7;
            }

            $schedule = Schedule::create($validated);

            $schedule->load(['port', 'vessel']);

            $result = [
                'sched_id'       => $schedule->sched_id,
                'departure_time' => $schedule->departure_time,

                'vessel' => $schedule->vessel ? [
                    'id'   => $schedule->vessel->id,
                    'name' => $schedule->vessel->vessel_name,
                ] : null,

                'port' => $schedule->port ? [
                    'id'   => $schedule->port->port_id,
                    'name' => $schedule->port->port_name,
                ] : null,

                'status'     => $schedule->status,
                'visibility' => $schedule->visibility,
                'created_at' => $schedule->created_at,
                'updated_at' => $schedule->updated_at,
            ];

            return $this->success(
                ['schedule' => $result],
                'Schedule created successfully.',
                201
            );

        } catch (\Throwable $e) {
            throw new Exception('Failed to create schedule: ' . $e->getMessage(), 500);
        }
    }
}
