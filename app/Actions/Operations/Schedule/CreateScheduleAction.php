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
                'route_id'       => 'required|exists:routes,route_id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $schedule = Schedule::create([
                'departure_time' => $data['departure_time'],
                'vessel_id'      => $data['vessel_id'] ?? null,
                'route_id'       => $data['route_id'],
            ]);

            $schedule->load(['route.portA', 'route.portB']);

            $vessel = null;
            if (!empty($schedule->vessel_id)) {
                $vessel = \DB::table('vessels')->where('id', $schedule->vessel_id)->first();
            }

            $result = [
                'sched_id'        => $schedule->sched_id,
                'departure_time'  => $schedule->departure_time,
                'vessel_id'       => $schedule->vessel_id,
                'vessel_name'     => $vessel->vessel_name ?? null,
                'route_id'        => $schedule->route_id,
                'route_name'      => $schedule->route?->route_name,
                'port_a_name'     => $schedule->route?->portA?->port_name,
                'port_b_name'     => $schedule->route?->portB?->port_name,
                'created_at'      => $schedule->created_at,
                'updated_at'      => $schedule->updated_at,
            ];

            return $this->success([
                'schedule' => $result,
            ], 'Schedule created successfully.', 201);

        } catch (\Throwable $e) {
            $code = is_numeric($e->getCode()) ? (int) $e->getCode() : 500;
            throw new Exception('Failed to create schedule: ' . $e->getMessage(), $code);
        }
    }
}
