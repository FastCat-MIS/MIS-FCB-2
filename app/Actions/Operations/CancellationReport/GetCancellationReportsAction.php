<?php

namespace App\Actions\Operations\CancellationReport;

use App\Actions\Action;
use App\Models\Operations\CancellationReport;

class GetCancellationReportsAction extends Action
{
    public function execute()
    {
        try {
            $reports = CancellationReport::with([
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])->get();

            return $this->success([
                'cancellation_reports' => $reports
            ], 'Cancellation reports retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve cancellation reports: ' . $e->getMessage(), 500);
        }
    }
}
