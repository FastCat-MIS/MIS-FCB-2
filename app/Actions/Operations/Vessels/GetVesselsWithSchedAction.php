<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;

class GetVesselsWithSchedAction extends Action
{
    public function execute()
    {
        try {
            $vessels = Vessel::with([
                'schedules:sched_id,vessel_id,departure_time,arrival_time'
            ])->get();
            
            return $this->success([
                'vessels' => $vessels
            ], 'Vessels retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve vessels: ' . $e->getMessage(), 500);
        }
    }
}
