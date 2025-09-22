<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operations\RouteController;
use App\Http\Controllers\Operations\ScheduleController;
use App\Http\Controllers\Operations\VesselController;

// Operations domain routes - REMOVE the 'operations' prefix
Route::middleware('jwt.auth')->group(function () {

    // // Routes CRUD - this will create /api/routes
    // Route::prefix('routes')->group(function () {
    //     Route::get('/', [RouteController::class, 'index']);
    //     Route::get('/{route}', [RouteController::class, 'show']);
    //     Route::post('/', [RouteController::class, 'store'])->middleware('permission:create routes');
    //     Route::put('/{route}', [RouteController::class, 'update'])->middleware('permission:edit routes');
    //     Route::delete('/{route}', [RouteController::class, 'destroy'])->middleware('permission:delete routes');
    // });

    // routes/api/Operations/routes.php - Remove permission middleware temporarily
    Route::prefix('routes')->group(function () {
        Route::get('/', [RouteController::class, 'index']);
        Route::get('/{route}', [RouteController::class, 'show']);
        Route::post('/', [RouteController::class, 'store']); // Removed middleware
        Route::put('/{route}', [RouteController::class, 'update']); // Removed middleware
        Route::delete('/{route}', [RouteController::class, 'destroy']); // Removed middleware
    });
    // // Schedules CRUD - this will create /api/schedules
    // Route::prefix('schedules')->group(function () {
    //     Route::get('/', [ScheduleController::class, 'index']);
    //     Route::get('/{schedule}', [ScheduleController::class, 'show']);
    //     Route::post('/', [ScheduleController::class, 'store'])->middleware('permission:create schedules');
    //     Route::put('/{schedule}', [ScheduleController::class, 'update'])->middleware('permission:edit schedules');
    //     Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->middleware('permission:delete schedules');
    // });
    // Schedules CRUD - this will create /api/schedules
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('/{schedule}', [ScheduleController::class, 'show']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::put('/{schedule}', [ScheduleController::class, 'update']);
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy']);
    });
    // // Vessels CRUD - this will create /api/vessels
    // Route::prefix('vessels')->group(function () {
    //     Route::get('/', [VesselController::class, 'index']);
    //     Route::get('/{vessel}', [VesselController::class, 'show']);
    //     Route::post('/', [VesselController::class, 'store'])->middleware('permission:create vessels');
    //     Route::put('/{vessel}', [VesselController::class, 'update'])->middleware('permission:edit vessels');
    //     Route::delete('/{vessel}', [VesselController::class, 'destroy'])->middleware('permission:delete vessels');
    // });

});
