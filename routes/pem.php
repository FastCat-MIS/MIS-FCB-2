<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Pem\RegisterPemClientAction;
use App\Actions\Pem\GeneratePemJwtAction;

// PEM Client Registration (Admin endpoint - should be protected)
Route::post('/pem/register', function (Illuminate\Http\Request $request) {
    return app(RegisterPemClientAction::class)->execute($request->all());
});

// Generate JWT Token with PEM Authentication
Route::post('/pem/token', function (Illuminate\Http\Request $request) {
    return app(GeneratePemJwtAction::class)->execute($request->all());
});

// Get nonce for signing (client requests this first)
Route::get('/pem/nonce', function () {
    return response()->json([
        'nonce' => bin2hex(random_bytes(16)), // 32-character hex nonce
        'expires_in' => 1800, // 30 minutes
    ]);
});
