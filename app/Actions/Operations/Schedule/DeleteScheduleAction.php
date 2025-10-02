<?php
// app/Actions/Operations/Schedule/DeleteScheduleAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;

class DeleteScheduleAction extends Action
{
    public function execute(Schedule $schedule)
    {
        try {
            $schedule->delete();

            return $this->success([], 'Schedule deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete schedule.', 500, $e->getMessage());
        }
    }
}
