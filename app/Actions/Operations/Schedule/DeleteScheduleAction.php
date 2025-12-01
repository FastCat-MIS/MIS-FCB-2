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

            // Return HTTP 204 No Content
            return response()->noContent(); // Laravel helper for 204
        } catch (\Throwable $e) {
            throw new Exception('Failed to delete schedule: ' . $e->getMessage(), 500);
        }
    }
}
