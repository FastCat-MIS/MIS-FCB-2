<?php

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

            return $this->success([], 'Schedule deleted successfully.');

        } catch (\Throwable $e) {
            $code = is_numeric($e->getCode()) ? (int) $e->getCode() : 500;
            throw new Exception('Failed to delete schedule: ' . $e->getMessage(), $code);
        }
    }
}
