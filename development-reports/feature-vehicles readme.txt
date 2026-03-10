Vehicles Feature 
- Brando Calvento

Summary:
- Created Simple CRUD for vehicles feature
- No other functions/relation yet, i.e rates, vessels, passenger

Deleted the followings :
Tables
  1. vehicle_types
  2. vehicle_groups
  3. vehicle_brands

Created the followings :
Tables
  1. Vehicles

Variables
  1. vehicle_id => int
  2. vehicle_type => tinyInteger
  3. vehicle_class => string

Model
  1. Vehicle

Controller
  1. VehicleController

Actions
  1. CreateVehicleAction
  2. GetVehicleAction => by ID
  3. GetVehiclesAction  
  4. UpdateVehicleAction => by ID
  5. DeleteVehicleAction => by ID

Routes

 Route::prefix('vehicle')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::get('/{vehicleId}', [VehicleController::class, 'show']);
        Route::post('/', [VehicleController::class, 'store']);
        Route::put('/{vehicleId}', [VehicleController::class, 'update']);
        Route::delete('/{vehicleId}', [VehicleController::class, 'destroy']);

        // Route::get('/', [VehicleController::class, 'index'])->middleware('permission:vehicle read');
        // Route::get('/{vehicleId}', [VehicleController::class, 'show'])->middleware('permission:vehicle read');
        // Route::post('/', [VehicleController::class, 'store'])->middleware('permission:vehicle create');
        // Route::put('/{vehicleId}', [VehicleController::class, 'update'])->middleware('permission:vehicle update');
        // Route::delete('/{vehicleId}', [VehicleController::class, 'destroy'])->middleware('permission:vehicle delete');
    });

