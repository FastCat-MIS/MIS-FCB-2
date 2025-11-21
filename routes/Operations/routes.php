<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operations\RouteController;
use App\Http\Controllers\Operations\ScheduleController;
// use App\Http\Controllers\Operations\Vehicles\VesselController;
use App\Http\Controllers\Operations\Vehicles\VehicleGroupController;
use App\Http\Controllers\Operations\Vehicles\VehicleTypeController;
use App\Http\Controllers\Operations\Vehicles\VehicleBrandController;
use App\Http\Controllers\Operations\Passengers\PassengerCategoryController;
use App\Http\Controllers\Operations\Passengers\PassengerAccommodationController;
use App\Http\Controllers\Operations\Passengers\PassengerTypeController;
use App\Http\Controllers\Operations\PortController;

// Operations domain routes
Route::middleware('jwt.auth')->group(function () {

    // Routes CRUD
    Route::prefix('routes')->group(function () {
        Route::get('/', [RouteController::class, 'index']);
        Route::get('/with-schedules', [RouteController::class, 'routesWithSchedules']);
        Route::get('/{route}', [RouteController::class, 'show']);
        Route::post('/', [RouteController::class, 'store']);
        Route::put('/{route}', [RouteController::class, 'update']);
        Route::delete('/{route}', [RouteController::class, 'destroy']);

        // Middleware ready-to-enable comments
        // Route::get('/', [RouteController::class, 'index'])->middleware('permission:route management read');
        // Route::get('/{route}', [RouteController::class, 'show'])->middleware('permission:route management read');
        // Route::post('/', [RouteController::class, 'store'])->middleware('permission:route management create');
        // Route::put('/{route}', [RouteController::class, 'update'])->middleware('permission:route management update');
        // Route::delete('/{route}', [RouteController::class, 'destroy'])->middleware('permission:route management delete');
        // Route::get('/with-schedules', [RouteController::class, 'routesWithSchedules'])->middleware('permission:route management read');

    });

    // Schedules CRUD
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('/{schedule}', [ScheduleController::class, 'show']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::put('/{schedule}', [ScheduleController::class, 'update']);
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy']);

        // Route::get('/', [ScheduleController::class, 'index'])->middleware('permission:schedule management read');
        // Route::get('/{schedule}', [ScheduleController::class, 'show'])->middleware('permission:schedule management read');
        // Route::post('/', [ScheduleController::class, 'store'])->middleware('permission:schedule management create');
        // Route::put('/{schedule}', [ScheduleController::class, 'update'])->middleware('permission:schedule management update');
        // Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->middleware('permission:schedule management delete');
    });

    // Vessels CRUD
    // Route::prefix('vessels')->group(function () {
    //     Route::get('/', [VesselController::class, 'index']);
    //     Route::get('/{vessel}', [VesselController::class, 'show']);
    //     Route::post('/', [VesselController::class, 'store']);
    //     Route::put('/{vessel}', [VesselController::class, 'update']);
    //     Route::delete('/{vessel}', [VesselController::class, 'destroy']);

        // Route::get('/', [VesselController::class, 'index'])->middleware('permission:vessel management read');
        // Route::get('/{vessel}', [VesselController::class, 'show'])->middleware('permission:vessel management read');
        // Route::post('/', [VesselController::class, 'store'])->middleware('permission:vessel management create');
        // Route::put('/{vessel}', [VesselController::class, 'update'])->middleware('permission:vessel management update');
        // Route::delete('/{vessel}', [VesselController::class, 'destroy'])->middleware('permission:vessel management delete');
    // });

    // Passenger Categories CRUD
    Route::prefix('passenger-categories')->group(function () {
        Route::get('/', [PassengerCategoryController::class, 'index']);
        Route::get('/{passengerCategory}', [PassengerCategoryController::class, 'show']);
        Route::post('/', [PassengerCategoryController::class, 'store']);
        Route::put('/{passengerCategory}', [PassengerCategoryController::class, 'update']);
        Route::delete('/{passengerCategory}', [PassengerCategoryController::class, 'destroy']);

        // Route::get('/', [PassengerCategoryController::class, 'index'])->middleware('permission:passenger category management read');
        // Route::get('/{passengerCategory}', [PassengerCategoryController::class, 'show'])->middleware('permission:passenger category management read');
        // Route::post('/', [PassengerCategoryController::class, 'store'])->middleware('permission:passenger category management create');
        // Route::put('/{passengerCategory}', [PassengerCategoryController::class, 'update'])->middleware('permission:passenger category management update');
        // Route::delete('/{passengerCategory}', [PassengerCategoryController::class, 'destroy'])->middleware('permission:passenger category management delete');
    });

    // Passenger Types CRUD
    Route::prefix('passenger-types')->group(function () {
        Route::get('/', [PassengerTypeController::class, 'index']);
        Route::get('/{passengerType}', [PassengerTypeController::class, 'show']);
        Route::post('/', [PassengerTypeController::class, 'store']);
        Route::put('/{passengerType}', [PassengerTypeController::class, 'update']);
        Route::delete('/{passengerType}', [PassengerTypeController::class, 'destroy']);

        // Route::get('/', [PassengerTypeController::class, 'index'])->middleware('permission:passenger type management read');
        // Route::get('/{passengerType}', [PassengerTypeController::class, 'show'])->middleware('permission:passenger type management read');
        // Route::post('/', [PassengerTypeController::class, 'store'])->middleware('permission:passenger type management create');
        // Route::put('/{passengerType}', [PassengerTypeController::class, 'update'])->middleware('permission:passenger type management update');
        // Route::delete('/{passengerType}', [PassengerTypeController::class, 'destroy'])->middleware('permission:passenger type management delete');
    });

    // Passenger Accommodations CRUD
    Route::prefix('passenger-accommodations')->group(function () {
        Route::get('/', [PassengerAccommodationController::class, 'index']);
        Route::get('/{passengerAccommodation}', [PassengerAccommodationController::class, 'show']);
        Route::post('/', [PassengerAccommodationController::class, 'store']);
        Route::put('/{passengerAccommodation}', [PassengerAccommodationController::class, 'update']);
        Route::delete('/{passengerAccommodation}', [PassengerAccommodationController::class, 'destroy']);

        // Route::get('/', [PassengerAccommodationController::class, 'index'])->middleware('permission:passenger accommodation management read');
        // Route::get('/{passengerAccommodation}', [PassengerAccommodationController::class, 'show'])->middleware('permission:passenger accommodation management read');
        // Route::post('/', [PassengerAccommodationController::class, 'store'])->middleware('permission:passenger accommodation management create');
        // Route::put('/{passengerAccommodation}', [PassengerAccommodationController::class, 'update'])->middleware('permission:passenger accommodation management update');
        // Route::delete('/{passengerAccommodation}', [PassengerAccommodationController::class, 'destroy'])->middleware('permission:passenger accommodation management delete');
    });

    // Vehicle Groups CRUD
    Route::prefix('vehicle-groups')->group(function () {
        Route::get('/', [VehicleGroupController::class, 'index']);
        Route::get('/{vehicleGroup}', [VehicleGroupController::class, 'show']);
        Route::post('/', [VehicleGroupController::class, 'store']);
        Route::put('/{vehicleGroup}', [VehicleGroupController::class, 'update']);
        Route::delete('/{vehicleGroup}', [VehicleGroupController::class, 'destroy']);

        // Route::get('/', [VehicleGroupController::class, 'index'])->middleware('permission:vehicle group read');
        // Route::get('/{vehicleGroup}', [VehicleGroupController::class, 'show'])->middleware('permission:vehicle group read');
        // Route::post('/', [VehicleGroupController::class, 'store'])->middleware('permission:vehicle group create');
        // Route::put('/{vehicleGroup}', [VehicleGroupController::class, 'update'])->middleware('permission:vehicle group update');
        // Route::delete('/{vehicleGroup}', [VehicleGroupController::class, 'destroy'])->middleware('permission:vehicle group delete');
    });

    // Vehicle Types CRUD
    Route::prefix('vehicle-types')->group(function () {
        Route::get('/', [VehicleTypeController::class, 'index']);
        Route::get('/{vehicleType}', [VehicleTypeController::class, 'show']);
        Route::post('/', [VehicleTypeController::class, 'store']);
        Route::put('/{vehicleType}', [VehicleTypeController::class, 'update']);
        Route::delete('/{vehicleType}', [VehicleTypeController::class, 'destroy']);

        // Route::get('/', [VehicleTypeController::class, 'index'])->middleware('permission:vehicle type read');
        // Route::get('/{vehicleType}', [VehicleTypeController::class, 'show'])->middleware('permission:vehicle type read');
        // Route::post('/', [VehicleTypeController::class, 'store'])->middleware('permission:vehicle type create');
        // Route::put('/{vehicleType}', [VehicleTypeController::class, 'update'])->middleware('permission:vehicle type update');
        // Route::delete('/{vehicleType}', [VehicleTypeController::class, 'destroy'])->middleware('permission:vehicle type delete');
    });

    // Vehicle Brands CRUD
    Route::prefix('vehicle-brands')->group(function () {
        Route::get('/', [VehicleBrandController::class, 'index']);
        Route::get('/{vehicleBrand}', [VehicleBrandController::class, 'show']);
        Route::post('/', [VehicleBrandController::class, 'store']);
        Route::put('/{vehicleBrand}', [VehicleBrandController::class, 'update']);
        Route::delete('/{vehicleBrand}', [VehicleBrandController::class, 'destroy']);

        // Route::get('/', [VehicleBrandController::class, 'index'])->middleware('permission:vehicle brand read');
        // Route::get('/{vehicleBrand}', [VehicleBrandController::class, 'show'])->middleware('permission:vehicle brand read');
        // Route::post('/', [VehicleBrandController::class, 'store'])->middleware('permission:vehicle brand create');
        // Route::put('/{vehicleBrand}', [VehicleBrandController::class, 'update'])->middleware('permission:vehicle brand update');
        // Route::delete('/{vehicleBrand}', [VehicleBrandController::class, 'destroy'])->middleware('permission:vehicle brand delete');
    });

    // Port CRUD

    Route::prefix('ports')->group(function () {
        Route::get('/', [PortController::class, 'index']);
        Route::get('/{port}', [PortController::class, 'show']);
        Route::post('/', [PortController::class, 'store']);
        Route::put('/{port}', [PortController::class, 'update']);
        Route::delete('/{port}', [PortController::class, 'destroy']);
    });

});
