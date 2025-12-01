<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Schedule\GetSchedulesAction;
use App\Actions\Operations\Schedule\GetScheduleAction;
use App\Actions\Operations\Schedule\CreateScheduleAction;
use App\Actions\Operations\Schedule\UpdateScheduleAction;
use App\Actions\Operations\Schedule\DeleteScheduleAction;
use App\Models\Operations\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(GetSchedulesAction $getSchedulesAction)
    {
        return $getSchedulesAction->execute();
    }

    public function show(Schedule $schedule, GetScheduleAction $getScheduleAction)
    {
        return $getScheduleAction->execute($schedule);
    }

    public function store(Request $request, CreateScheduleAction $createScheduleAction)
    {
        return $createScheduleAction->execute($request->only([
            'departure_time',
            'vessel_id',
            'route_id'
        ]));
    }

    public function update(Request $request, Schedule $schedule, UpdateScheduleAction $updateScheduleAction)
    {
        return $updateScheduleAction->execute($schedule, $request->only([
            'departure_time',
            'vessel_id',
            'route_id'
        ]));
    }

    public function destroy(Schedule $schedule, DeleteScheduleAction $deleteScheduleAction)
    {
        return $deleteScheduleAction->execute($schedule);
    }
}
