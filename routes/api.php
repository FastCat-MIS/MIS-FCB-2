<?php

use Illuminate\Support\Facades\Route;

// Public routes - NO JWT middleware
Route::post('/register', function (Illuminate\Http\Request $request) {
    return App\Actions\Accounts\Auth\RegisterAction::make()->run($request->all());
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    return App\Actions\Accounts\Auth\LoginAction::make()->run($request->all());
});

Route::post('/refresh', function () {
    try {
        $authorizationHeader = request()->header('Authorization');
        $token = null;

        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Bearer ')) {
            $token = substr($authorizationHeader, 7);
        }

        $newToken = \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->refresh();
        $bearerToken = 'Bearer ' . $newToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Token refreshed',
            'data' => [
                'token' => $bearerToken,
                'token_type' => 'Bearer',
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unable to refresh token',
            'error_code' => 'TOKEN_REFRESH_FAILED'
        ], 401);
    }
});

// Health check endpoint - NO JWT middleware
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is running with JWT authentication',
        'timestamp' => now()->toISOString()
    ]);
});

// Load domain-specific route files - NO PREFIX NEEDED
require __DIR__ . '/Accounts/auth.php';
require __DIR__ . '/Operations/routes.php';
require __DIR__ . '/Marketing/routes.php';
require __DIR__ . '/Teller/routes.php';
require __DIR__ . '/pem.php';
