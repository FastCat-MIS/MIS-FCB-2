<?php
// app/Actions/Operations/Schedule/UpdateScheduleAction.php

namespace App\Actions\Operations\Schedule;

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
                'departure_time' => 'sometimes|required|date_format:H:i',
                'vessel' => 'sometimes|required|string|max:100',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $schedule->update($data);

            return $this->success([
                'schedule' => $schedule->fresh(),
            ], 'Schedule updated successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to update schedule.', 500, $e->getMessage());
        }
    }
}
