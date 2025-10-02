<?php
// app/Actions/Operations/Schedule/GetScheduleAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;

class GetScheduleAction extends Action
{
    public function execute(Schedule $schedule, array $data = [])
    {
        try {
            return $this->success([
                'schedule' => $schedule,
            ], 'Schedule retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve schedule.', 500, $e->getMessage());
        }
    }
}
