<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Operations\Vdar;

class GetVdarAction extends Action
{
    public function execute(Vdar $vdar)
    {
        try {
            return $this->success([
                'vdar' => $vdar->load([
                    'schedule:sched_id,departure_time,arrival_time',
                    'vesselMaster:id,first_name,middle_name,last_name',
                ])
            ], 'VDAR retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve VDAR: ' . $e->getMessage(), 500);
        }
    }
}
