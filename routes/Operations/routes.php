<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operations\RouteController;
use App\Http\Controllers\Operations\ScheduleController;
// use App\Http\Controllers\Operations\Vehicles\VesselController;
use App\Http\Controllers\Operations\Passengers\PassengerCategoryController;
use App\Http\Controllers\Operations\Passengers\PassengerAccommodationController;
use App\Http\Controllers\Operations\Passengers\PassengerTypeController;
use App\Http\Controllers\Operations\PortController;
use App\Http\Controllers\Operations\BookingController;
use App\Http\Controllers\Operations\BookedPassengerController;
use App\Http\Controllers\Operations\ConnectingTripController;
use App\Http\Controllers\Operations\VesselController;
use App\Http\Controllers\Operations\VesselLayoutController;
use App\Http\Controllers\Marketing\RouteRateController;

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

        Route::get('{route}/rates', [RouteRateController::class, 'index']);
        Route::post('{route}/rates', [RouteRateController::class, 'store']);
        Route::put('{route}/rates', [RouteRateController::class, 'update']);
        Route::delete('{route}/rates/{rate}', [RouteRateController::class, 'destroy']);

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
    Route::prefix('vessels')->group(function () {
        Route::get('/', [VesselController::class, 'index']);
        Route::get('/{vessel}', [VesselController::class, 'show']);
        Route::post('/', [VesselController::class, 'store']);
        Route::put('/{vessel}', [VesselController::class, 'update']);
        Route::delete('/{vessel}', [VesselController::class, 'destroy']);

    Route::prefix('{vessel}/layout')->group(function () {
        Route::get('/', [VesselLayoutController::class, 'show']);
        Route::post('/', [VesselLayoutController::class, 'store']);
        Route::put('/', [VesselLayoutController::class, 'update']);
        Route::patch('/', [VesselLayoutController::class, 'update']); // partial update
        Route::delete('/', [VesselLayoutController::class, 'destroy']);
    });
    //     // Route::get('/', [VesselController::class, 'index'])->middleware('permission:vessel management read');
    //     // Route::get('/{vessel}', [VesselController::class, 'show'])->middleware('permission:vessel management read');
    //     // Route::post('/', [VesselController::class, 'store'])->middleware('permission:vessel management create');
    //     // Route::put('/{vessel}', [VesselController::class, 'update'])->middleware('permission:vessel management update');
    //     // Route::delete('/{vessel}', [VesselController::class, 'destroy'])->middleware('permission:vessel management delete');
    });

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

    // Vehicle  CRUD
    // Route::prefix('vehicle-groups')->group(function () {
    //     Route::get('/', [VehicleGroupController::class, 'index']);
    //     Route::get('/{vehicleGroup}', [VehicleGroupController::class, 'show']);
    //     Route::post('/', [VehicleGroupController::class, 'store']);
    //     Route::put('/{vehicleGroup}', [VehicleGroupController::class, 'update']);
    //     Route::delete('/{vehicleGroup}', [VehicleGroupController::class, 'destroy']);

        // Route::get('/', [VehicleGroupController::class, 'index'])->middleware('permission:vehicle group read');
        // Route::get('/{vehicleGroup}', [VehicleGroupController::class, 'show'])->middleware('permission:vehicle group read');
        // Route::post('/', [VehicleGroupController::class, 'store'])->middleware('permission:vehicle group create');
        // Route::put('/{vehicleGroup}', [VehicleGroupController::class, 'update'])->middleware('permission:vehicle group update');
        // Route::delete('/{vehicleGroup}', [VehicleGroupController::class, 'destroy'])->middleware('permission:vehicle group delete');
    // });



    // Port CRUD
    Route::prefix('ports')->group(function () {
        Route::get('/', [PortController::class, 'index']);
        Route::get('/{port}', [PortController::class, 'show']);
        Route::post('/', [PortController::class, 'store']);
        Route::put('/{port}', [PortController::class, 'update']);
        Route::delete('/{port}', [PortController::class, 'destroy']);

        // Route::get('/', [PortController::class, 'index'])->middleware('permission:port management read');
        // Route::get('/{port}', [PortController::class, 'show'])->middleware('permission:port management read');
        // Route::post('/', [PortController::class, 'store'])->middleware('permission:port management create');
        // Route::put('/{port}', [PortController::class, 'update'])->middleware('permission:port management update');
        // Route::delete('/{port}', [PortController::class, 'destroy'])->middleware('permission:port management delete');
    });

    // Bookings CRUD
    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/search', [BookingController::class, 'searchByKeyword']);
        Route::get('/{booking}', [BookingController::class, 'show']);
        Route::post('/', [BookingController::class, 'store']);
        Route::put('/{booking}', [BookingController::class, 'update']);
        Route::delete('/{booking}', [BookingController::class, 'destroy']);

        // Route::get('/', [BookingController::class, 'index'])->middleware('permission:booking management read');
        // Route::get('/{booking}', [BookingController::class, 'show'])->middleware('permission:booking management read');
        // Route::post('/', [BookingController::class, 'store'])->middleware('permission:booking management create');
        // Route::put('/{booking}', [BookingController::class, 'update'])->middleware('permission:booking management update');
        // Route::delete('/{booking}', [BookingController::class, 'destroy'])->middleware('permission:booking management delete');
        // Route::get('/search', [BookingController::class, 'searchByKeyword'])->middleware('permission:booking management read');
    });

    // Booked Passengers CRUD
    Route::prefix('booked-passenger')->group(function () {
        Route::get('/', [BookedPassengerController::class, 'index']);
        Route::get('/search', [BookedPassengerController::class, 'searchByKeyword']);
        Route::get('/{bookedPassenger}', [BookedPassengerController::class, 'show']);
        Route::post('/', [BookedPassengerController::class, 'store']);
        Route::put('/{bookedPassenger}', [BookedPassengerController::class, 'update']);
        Route::delete('/{bookedPassenger}', [BookedPassengerController::class, 'destroy']);

        // Route::get('/', [BookedPassengerController::class, 'index'])->middleware('permission:booked passenger management read');
        // Route::get('/{bookedPassenger}', [BookedPassengerController::class, 'show'])->middleware('permission:booked passenger management read');
        // Route::post('/', [BookedPassengerController::class, 'store'])->middleware('permission:booked passenger management create');
        // Route::put('/{bookedPassenger}', [BookedPassengerController::class, 'update'])->middleware('permission:booked passenger management update');
        // Route::delete('/{bookedPassenger}', [BookedPassengerController::class, 'destroy'])->middleware('permission:booked passenger management delete');
        // Route::get('/search', [BookedPassengerController::class, 'searchByKeyword'])->middleware('permission:booked passenger management read'); // new
    });

    // Connecting Trips CRUD
    Route::prefix('connecting-trips')->group(function () {
        Route::get('/', [ConnectingTripController::class, 'index']);
        Route::get('/search', [ConnectingTripController::class, 'searchByKeyword']);
        Route::get('/{connectingTrip}', [ConnectingTripController::class, 'show']);
        Route::post('/', [ConnectingTripController::class, 'store']);
        Route::put('/{connectingTrip}', [ConnectingTripController::class, 'update']);
        Route::delete('/{connectingTrip}', [ConnectingTripController::class, 'destroy']);

        // Route::get('/', [ConnectingTripController::class, 'index'])->middleware('permission:connecting trip management read');
        // Route::get('/{connectingTrip}', [ConnectingTripController::class, 'show'])->middleware('permission:connecting trip management read');
        // Route::post('/', [ConnectingTripController::class, 'store'])->middleware('permission:connecting trip management create');
        // Route::put('/{connectingTrip}', [ConnectingTripController::class, 'update'])->middleware('permission:connecting trip management update');
        // Route::delete('/{connectingTrip}', [ConnectingTripController::class, 'destroy'])->middleware('permission:connecting trip management delete');
        // Route::get('/search', [ConnectingTripController::class, 'searchByKeyword'])->middleware('permission:connecting trip management read');
    });

});
