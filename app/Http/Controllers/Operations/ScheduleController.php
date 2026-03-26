<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Operations\Schedule\GetSchedulesAction;
use App\Actions\Operations\Schedule\GetScheduleAction;
use App\Actions\Operations\Schedule\CreateScheduleAction;
use App\Actions\Operations\Schedule\UpdateScheduleAction;
use App\Actions\Operations\Schedule\DeleteScheduleAction;
use App\Models\Operations\Schedule;

class ScheduleController extends Controller
{
    public function index(GetSchedulesAction $action)
    {
        return $action->execute();
    }
    
    public function show(Schedule $schedule, GetScheduleAction $action)
    {
        return $action->execute($schedule);
    }

    public function store(Request $request, CreateScheduleAction $action)
    {
        return $action->execute($request->only([
            'departure_time',
            'vessel_id',
            'port_id',
            'is_active',
            'status',
            'visibility'
        ]));
    }

    public function update(Request $request, Schedule $schedule, UpdateScheduleAction $action)
    {
        return $action->execute($schedule, $request->only([
            'departure_time',
            'vessel_id',
            'port_id',
            'is_active',
            'status',
            'visibility'
        ]));
    }

    public function destroy(Schedule $schedule, DeleteScheduleAction $action)
    {
        return $action->execute($schedule);
    }
}
