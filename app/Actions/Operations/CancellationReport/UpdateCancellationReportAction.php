<?php

namespace App\Actions\Operations\CancellationReport;

use App\Actions\Action;
use App\Models\Accounts\User;
use App\Models\Operations\CancellationReport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateCancellationReportAction extends Action
{
    public function execute(CancellationReport $cancellationReport, array $data)
    {
        $validator = Validator::make($data, [
            'port_id'                 => 'sometimes|exists:ports,port_id',
            'vessel_id'               => 'sometimes|exists:vessels,id',
            'schedule_id'             => 'sometimes|exists:schedules,sched_id',
            'vessel_master_id'        => ['sometimes', 'exists:users,id', function ($_, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('Vessel Master')) {
                    $fail('The selected vessel master must have the Vessel Master role.');
                }
            }],
            'num_passengers_affected' => 'sometimes|integer|min:0',
            'num_rcs_affected'        => 'sometimes|integer|min:0',
            'est_revenue_loss'        => 'sometimes|numeric|min:0',
            'cancellation_category'   => 'sometimes|string|max:255',
            'cancellation_type'       => 'sometimes|string|max:255',
            'consulted_dept'          => 'sometimes|string|max:255',
            'reason_of_cancel'        => 'sometimes|string',
            'recommendation'          => 'nullable|string',
            'documents'               => 'nullable|array',
            'documents.*'             => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        if (!empty($validated['documents'])) {
            // Delete old files before replacing
            if ($cancellationReport->documents) {
                foreach ($cancellationReport->documents as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $validated['documents'] = collect($validated['documents'])
                ->map(fn (UploadedFile $file) => $file->store('cancellation-reports', 'public'))
                ->values()
                ->all();
        }

        $cancellationReport->update($validated);

        return $this->success([
            'cancellation_report' => $cancellationReport->fresh()->load([
                'port:port_id,port_name',
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])
        ], 'Cancellation report updated successfully.');
    }
}
