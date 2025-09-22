<?php
// app/Http/Controllers/Operations/ScheduleController.php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Schedule\GetSchedulesAction;
use App\Actions\Schedule\GetScheduleAction;
use App\Actions\Schedule\CreateScheduleAction;
use App\Actions\Schedule\UpdateScheduleAction;
use App\Actions\Schedule\DeleteScheduleAction;
use App\Models\Operations\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index(GetSchedulesAction $getSchedulesAction)
    {
        return $getSchedulesAction->execute();
    }

    /**
     * Display the specified schedule.
     */
    public function show(Schedule $schedule, GetScheduleAction $getScheduleAction)
    {
        return $getScheduleAction->execute($schedule);
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request, CreateScheduleAction $createScheduleAction)
    {
        return $createScheduleAction->execute($request->all());
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, Schedule $schedule, UpdateScheduleAction $updateScheduleAction)
    {
        return $updateScheduleAction->execute($schedule, $request->all());
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(Schedule $schedule, DeleteScheduleAction $deleteScheduleAction)
    {
        return $deleteScheduleAction->execute($schedule);
    }
}
