<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Operations\Vessel;

class GetVdarsByVesselAction extends Action
{
    public function execute(Vessel $vessel)
    {
        try {
            $vdars = $vessel->vdars()->with([
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])->get();

            return $this->success([
                'vessel' => $vessel->only(['id', 'vessel_name']),
                'vdars'  => $vdars,
            ], 'VDARs retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve VDARs: ' . $e->getMessage(), 500);
        }
    }
}
