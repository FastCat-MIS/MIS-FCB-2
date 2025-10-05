<?php
// app/Actions/Operations/Schedule/UpdateScheduleAction.php

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
            // Validate input
            $validator = Validator::make($data, [
                'departure_time' => 'sometimes|required|date_format:H:i',
                'vessel'         => 'sometimes|required|string|max:100',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Update schedule
            $schedule->update($data);

            return $this->success([
                'schedule' => $schedule->fresh(),
            ], 'Schedule updated successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to update schedule: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
