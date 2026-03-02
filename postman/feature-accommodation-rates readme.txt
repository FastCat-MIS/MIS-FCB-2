Accommodation Rates Feature
- Brando Calvento

Summary:
- Created Simple CRUD for accommodation rates feature
- pending function/relation for without ac variable to compute for without ac rate

Deleted the followings :
Tables
  1. rates

Created the followings :
Tables
  1. accommodation_rates

Variables
  1. acc_rate_id
  2. accommodation_id
  3. route_id
  4. base_rate
  5. effective_date
  6. status
  7. timestamp

Model
  1. AccommodationRate

Controller
  1. AccommodationRateController

Actions
  1. CreateAccommodationRateAction
  2. GetAccommodationRateAction => by Acc Rate ID
  3. GetAccommodationRatesAction
  5. GetRouteAccRatesAction => by Route ID
  6. UpdateAccommodationRateAction => by Acc Rate ID
  7. DeleteAccommodationRateAction => by Acc Rate ID

Routes

Route::prefix('accommodation-rates')->group(function () {
        Route::get('/', [AccommodationRateController::class, 'index']);
        Route::get('/{accRateId}', [AccommodationRateController::class, 'show']);
        Route::get('/route/{routeId}', [AccommodationRateController::class, 'showRoute']);
        Route::post('/', [AccommodationRateController::class, 'store']);
        Route::put('/{accRateId}', [AccommodationRateController::class, 'update']);
        Route::delete('/{accRateId}', [AccommodationRateController::class, 'destroy']);

    //     // Route::get('/', [AccommodationRateController::class, 'index'])->middleware('permission:accommodation rate management read');
    //     // Route::get('/{accRateId}', [AccommodationRateController::class, 'show'])->middleware('permission:accommodation rate management read');
    //     // Route::post('/', [AccommodationRateController::class, 'store'])->middleware('permission:accommodation rate management create');
    //     // Route::put('/{accRateId}', [AccommodationRateController::class, 'update'])->middleware('permission:accommodation rate management update');
    //     // Route::delete('/{accRateId}', [AccommodationRateController::class, 'destroy'])->middleware('permission:accommodation rate management delete');
    });
