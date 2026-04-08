<?php

namespace App\Actions\Operations\CancellationReport;

use App\Actions\Action;
use App\Models\Operations\CancellationReport;

class GetCancellationReportAction extends Action
{
    public function execute(CancellationReport $cancellationReport)
    {
        try {
            return $this->success([
                'cancellation_report' => $cancellationReport->load([
                    'schedule:sched_id,departure_time,arrival_time',
                    'vesselMaster:id,first_name,middle_name,last_name',
                ])
            ], 'Cancellation report retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve cancellation report: ' . $e->getMessage(), 500);
        }
    }
}
