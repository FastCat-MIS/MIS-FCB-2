<?php
// app/Actions/Schedule/GetSchedulesAction.php

namespace App\Actions\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;

class GetSchedulesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $schedules = Schedule::with(['route', 'vessel'])->get();

            return $this->success([
                'schedules' => $schedules,
            ], 'Schedules retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve schedules.', 500, $e->getMessage());
        }
    }
}
