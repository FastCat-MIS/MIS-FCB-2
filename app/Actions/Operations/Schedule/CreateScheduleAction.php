<?php
// app/Actions/Operations/Schedule/CreateScheduleAction.php

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
            // Validate input
            $validator = Validator::make($data, [
                'departure_time' => 'required|date_format:H:i',
                'vessel'         => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Create schedule
            $schedule = Schedule::create([
                'departure_time' => $data['departure_time'],
                'vessel'         => $data['vessel'],
            ]);

            return $this->success([
                'schedule' => $schedule,
            ], 'Schedule created successfully.', 201);

        } catch (\Throwable $e) {
            throw new Exception('Failed to create schedule: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
