<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Teller\ScheduleSeatLock;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Cleanup expired seat locks every 5 minutes
Schedule::call(function () {
    $deleted = ScheduleSeatLock::expired()->delete();
    \Log::info("Cleaned up {$deleted} expired seat locks");
})->everyFiveMinutes();
