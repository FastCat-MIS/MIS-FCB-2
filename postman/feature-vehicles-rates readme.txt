Vehicles Rates Feature 
- Brando Calvento

Summary:
- Created Simple CRUD for vehicles rates
- No other functions/relation yet, i.e rates, vessels, passenger, vehicles, 

Created the followings :
Tables
  1. vehicle_rates

Variables
  1. vehicle_id => relation to vehicles
  2. route_id => relation to routes
  3. vehicle_rate

Model
  1. VehicleRate

Controller
  1. VehicleRateController
 
Actions
  1. CreateVehicleRateAction
  2. GetVehicleRateAction => by ID
  3. GetVehicleRatesAction  
  4. UpdateVehicleRateAction => by ID
  5. DeleteVehicleRateAction => by ID

Routes

    Route::prefix('vehicle-rates')->group(function () {
        Route::get('/', [VehicleRateController::class, 'index']);
        Route::get('/{vehicleRateId}', [VehicleRateController::class, 'show']);
        Route::post('/', [VehicleRateController::class, 'store']);
        Route::put('/{vehicleRateId}', [VehicleRateController::class, 'update']);
        Route::delete('/{vehicleRateId}', [VehicleRateController::class, 'destroy']);

    //     // Route::get('/', [VehicleRateController::class, 'index'])->middleware('permission:vehicle rate management read');
    //     // Route::get('/{vehicleRateId}', [VehicleRateController::class, 'show'])->middleware('permission:vehicle rate management read');
    //     // Route::post('/', [VehicleRateController::class, 'store'])->middleware('permission:vehicle rate management create');
    //     // Route::put('/{vehicleRateId}', [VehicleRateController::class, 'update'])->middleware('permission:vehicle rate management update');
    //     // Route::delete('/{vehicleRateId}', [VehicleRateController::class, 'destroy'])->middleware('permission:vehicle rate management delete');
    });

