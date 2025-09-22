<?php
// app/Actions/Schedule/CreateScheduleAction.php

namespace App\Actions\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\Validator;

class CreateScheduleAction extends Action
{
    public function execute(array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'route_id'        => 'required|exists:routes,route_id',
                'vessel_id'       => 'required|exists:vessels,vessel_id',
                'departure_time'  => 'required|date_format:H:i',
                'arrival_time'    => 'required|date_format:H:i|after:departure_time',
                'status'          => 'required|in:scheduled,departed,arrived,cancelled',
                'available_seats' => 'required|integer|min:0',
            ]);


            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            // Check for schedule conflicts
            $conflictingSchedule = Schedule::where('vessel_id', $data['vessel_id'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('departure_time', [$data['departure_time'], $data['arrival_time']])
                          ->orWhereBetween('arrival_time', [$data['departure_time'], $data['arrival_time']])
                          ->orWhere(function ($q) use ($data) {
                              $q->where('departure_time', '<=', $data['departure_time'])
                                ->where('arrival_time', '>=', $data['arrival_time']);
                          });
                })
                ->first();

            if ($conflictingSchedule) {
                return $this->error('Vessel is already scheduled during this time period.', 409);
            }

            // Create schedule
            $schedule = Schedule::create($data);

            return $this->success([
                'schedule' => $schedule->load(['route', 'vessel']),
            ], 'Schedule created successfully', 201);

        } catch (\Exception $e) {
            return $this->error('Failed to create schedule.', 500, $e->getMessage());
        }
    }
}
