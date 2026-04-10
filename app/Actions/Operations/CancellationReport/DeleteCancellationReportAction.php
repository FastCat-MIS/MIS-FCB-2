<?php

namespace App\Actions\Operations\CancellationReport;

use App\Actions\Action;
use App\Models\Operations\CancellationReport;
use Illuminate\Support\Facades\Storage;

class DeleteCancellationReportAction extends Action
{
    public function execute(CancellationReport $cancellationReport)
    {
        try {
            if ($cancellationReport->documents) {
                foreach ($cancellationReport->documents as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            $cancellationReport->delete();

            return $this->success([], 'Cancellation report deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to delete cancellation report: ' . $e->getMessage(), 500);
        }
    }
}
