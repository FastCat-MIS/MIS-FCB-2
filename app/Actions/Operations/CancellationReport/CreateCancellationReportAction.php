<?php

namespace App\Actions\Operations\CancellationReport;

use App\Actions\Action;
use App\Models\Accounts\User;
use App\Models\Operations\CancellationReport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateCancellationReportAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'vessel_id'               => 'required|exists:vessels,id',
            'schedule_id'             => 'required|exists:schedules,sched_id',
            'vessel_master_id'        => ['required', 'exists:users,id', function ($_attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('Vessel Master')) {
                    $fail('The selected vessel master must have the Vessel Master role.');
                }
            }],
            'num_passengers_affected' => 'required|integer|min:0',
            'num_rcs_affected'        => 'required|integer|min:0',
            'est_revenue_loss'        => 'required|numeric|min:0',
            'cancellation_category'   => 'required|string|max:255',
            'cancellation_type'       => 'required|string|max:255',
            'consulted_dept'          => 'required|string|max:255',
            'reason_of_cancel'        => 'required|string',
            'recommendation'          => 'nullable|string',
            'documents'               => 'nullable|array',
            'documents.*'             => 'file|mimes:pdf,jpg,jpeg,png,docx,xlsx|max:10240',        
            ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        if (!empty($validated['documents'])) {
            $year = now()->year;
            $base = CancellationReport::whereYear('created_at', $year)->count();

            $validated['documents'] = collect($validated['documents'])
        ->map(function (UploadedFile $file, int $index) use ($year, $base) {
            $count     = str_pad($base + $index + 1, 4, '0', STR_PAD_LEFT);
            $extension = $file->getClientOriginalExtension();
            $filename  = "CR-{$year}-{$count}.{$extension}";

            return $file->storeAs('cancellation-reports', $filename, 'public');
        })
        ->values()
        ->all();
}

        $report = CancellationReport::create($validated);

        return $this->success([
            'cancellation_report' => $report->load([
                'schedule:sched_id,departure_time,arrival_time',
                'vesselMaster:id,first_name,middle_name,last_name',
            ])
        ], 'Cancellation report created successfully.', 201);
    }
}
