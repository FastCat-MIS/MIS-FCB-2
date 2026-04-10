<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\CancellationReport\GetCancellationReportsAction;
use App\Actions\Operations\CancellationReport\GetCancellationReportAction;
use App\Actions\Operations\CancellationReport\CreateCancellationReportAction;
use App\Actions\Operations\CancellationReport\UpdateCancellationReportAction;
use App\Actions\Operations\CancellationReport\DeleteCancellationReportAction;
use App\Models\Operations\CancellationReport;
use Illuminate\Http\Request;

class CancellationReportController extends Controller
{
    public function index(GetCancellationReportsAction $action)
    {
        return $action->execute();
    }

    public function show(CancellationReport $cancellationReport, GetCancellationReportAction $action)
    {
        return $action->execute($cancellationReport);
    }

    public function store(Request $request, CreateCancellationReportAction $action)
    {
        $data = $request->all();
        if ($request->hasFile('documents')) {
            $data['documents'] = $request->file('documents');
        }
        return $action->execute($data);
    }

    public function update(Request $request, CancellationReport $cancellationReport, UpdateCancellationReportAction $action)
    {
        $data = $request->all();
        if ($request->hasFile('documents')) {
            $data['documents'] = $request->file('documents');
        }
        return $action->execute($cancellationReport, $data);
    }

    public function destroy(CancellationReport $cancellationReport, DeleteCancellationReportAction $action)
    {
        return $action->execute($cancellationReport);
    }
}
