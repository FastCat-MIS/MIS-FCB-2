<?php
// app/Actions/Operations/Schedule/CreateScheduleAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Illuminate\Support\Facades\Validator;

class CreateScheduleAction extends Action
{
    public function execute(array $data)
    {
        try {
            // Validate only what's in the simplified table
            $validator = Validator::make($data, [
                'departure_time' => 'required|date_format:H:i',
                'vessel'         => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            // Create schedule
            $schedule = Schedule::create([
                'departure_time' => $data['departure_time'],
                'vessel'         => $data['vessel'],
            ]);

            return $this->success([
                'schedule' => $schedule,
            ], 'Schedule created successfully', 201);

        } catch (\Exception $e) {
            return $this->error('Failed to create schedule.', 500, $e->getMessage());
        }
    }
}
