<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Auth\LogoutAction;
use App\Actions\User\GetProfileAction;
use App\Actions\User\UpdateProfileAction;

Route::middleware('jwt.auth')->prefix('account')->group(function () {

    // Auth routes
    Route::post('/logout', function (Illuminate\Http\Request $request) {
        return LogoutAction::make()->run($request->all());
    });

    // User profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', function (Illuminate\Http\Request $request) {
            return GetProfileAction::make()->run($request->all());
        });

        Route::put('/', function (Illuminate\Http\Request $request) {
            return UpdateProfileAction::make()->run($request->all());
        });
    });

    // Add other account-related routes here...
    // Route::get('/users', [UserController::class, 'index'])->middleware('permission:view users');
    // Route::put('/users/{user}', [UserController::class, 'update'])->middleware('permission:edit users');
});
