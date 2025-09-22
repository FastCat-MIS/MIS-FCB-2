<?php
// app/Actions/Schedule/UpdateScheduleAction.php

namespace App\Actions\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\Validator;

class UpdateScheduleAction extends Action
{
    public function execute(Schedule $schedule, array $data)
    {
        try {
            // Validate input
            $validator = Validator::make($data, [
                'route_id' => 'sometimes|required|exists:routes,route_id',
                'vessel_id' => 'sometimes|required|exists:vessels,vessel_id',
                'departure_time' => 'sometimes|required|date',
                'arrival_time' => 'sometimes|required|date|after:departure_time',
                'status' => 'sometimes|required|in:scheduled,departed,arrived,cancelled',
                'available_seats' => 'sometimes|required|integer|min:0',
                'fare' => 'sometimes|required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            // Check for schedule conflicts (excluding current schedule)
            if (isset($data['vessel_id']) || isset($data['departure_time']) || isset($data['arrival_time'])) {
                $vesselId = $data['vessel_id'] ?? $schedule->vessel_id;
                $departureTime = $data['departure_time'] ?? $schedule->departure_time;
                $arrivalTime = $data['arrival_time'] ?? $schedule->arrival_time;

                $conflictingSchedule = Schedule::where('vessel_id', $vesselId)
                    ->where('schedule_id', '!=', $schedule->schedule_id)
                    ->where(function ($query) use ($departureTime, $arrivalTime) {
                        $query->whereBetween('departure_time', [$departureTime, $arrivalTime])
                              ->orWhereBetween('arrival_time', [$departureTime, $arrivalTime])
                              ->orWhere(function ($q) use ($departureTime, $arrivalTime) {
                                  $q->where('departure_time', '<=', $departureTime)
                                    ->where('arrival_time', '>=', $arrivalTime);
                              });
                    })
                    ->first();

                if ($conflictingSchedule) {
                    return $this->error('Vessel is already scheduled during this time period.');
                }
            }

            // Update schedule
            $schedule->update($data);

            return $this->success([
                'schedule' => $schedule->fresh()->load(['route', 'vessel']),
            ], 'Schedule updated successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to update schedule.', $e->getMessage());
        }
    }
}
