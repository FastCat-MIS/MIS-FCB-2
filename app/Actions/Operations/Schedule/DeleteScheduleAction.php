<?php
// app/Actions/Operations/Schedule/DeleteScheduleAction.php

namespace App\Actions\Operations\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;
use Exception;

class DeleteScheduleAction extends Action
{
    public function execute(Schedule $schedule)
    {
        try {
            $schedule->delete();

            return $this->success([], 'Schedule deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new Exception('Failed to delete schedule: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
