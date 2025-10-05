<?php
// app/Actions/Operations/Schedule/GetScheduleAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Exception;

class GetScheduleAction extends Action
{
    public function execute(Schedule $schedule, array $data = [])
    {
        try {
            return $this->success([
                'schedule' => $schedule,
            ], 'Schedule retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve schedule: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
