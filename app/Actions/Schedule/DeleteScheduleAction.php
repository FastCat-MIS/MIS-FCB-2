<?php
// app/Actions/Schedule/DeleteScheduleAction.php

namespace App\Actions\Schedule;

use App\Actions\Action;
use App\Models\Operations\Schedule;

class DeleteScheduleAction extends Action
{
    public function execute(Schedule $schedule)
    {
        try {
            // Check if schedule has related bookings
            if ($schedule->bookings()->count() > 0) {
                return $this->error('Cannot delete schedule. It has associated bookings.', 409);
            }

            $schedule->delete();

            return $this->success([], 'Schedule deleted successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to delete schedule.', $e->getMessage());
        }
    }
}
