<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Auth\LogoutAction;
use App\Actions\User\GetProfileAction;
use App\Actions\User\UpdateProfileAction;
use App\Http\Controllers\Accounts\UserController;

Route::middleware('jwt.auth')->prefix('account')->group(function () {

    // Auth routes
    // Route::post('/logout', function (Illuminate\Http\Request $request) {
    //     return LogoutAction::make()->run($request->all());
    // });

    // User profile routes
    // Route::prefix('profile')->group(function () {
    //     Route::get('/', function (Illuminate\Http\Request $request) {
    //         return GetProfileAction::make()->run($request->all());
    //     });

    //     Route::put('/', function (Illuminate\Http\Request $request) {
    //         return UpdateProfileAction::make()->run($request->all());
    //     });
    // });

    // Users
    Route::get('/users/vessel-masters', [UserController::class, 'vesselMasters']);
});
