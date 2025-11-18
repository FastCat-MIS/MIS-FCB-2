<?php
// app/Actions/Operations/Schedule/GetSchedulesAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Exception;

class GetSchedulesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $schedules = Schedule::with(['portA', 'portB'])->get();

            return $this->success([
                'schedules' => $schedules,
            ], 'Schedules retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve schedules: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
