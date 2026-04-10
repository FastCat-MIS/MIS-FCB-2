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
                'schedules' => function ($query) {
                    $query->select('sched_id', 'vessel_id', 'port_id', 'departure_time', 'arrival_time')
                          ->with('port:port_id,port_name')
                          ->orderBy('departure_time');
                }
            ])->get();
            
            return $this->success([
                'vessels' => $vessels
            ], 'Vessels retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve vessels: ' . $e->getMessage(), 500);
        }
    }
}
