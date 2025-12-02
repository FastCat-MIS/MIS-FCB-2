<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: app()->environment('local') ? '/api' : null,

    )
    ->withMiddleware(function (Middleware $middleware) {
        // Configure basic API middleware without throttling for now
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Add CORS middleware globally
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        // Middleware aliases
        $middleware->alias([
            'jwt.auth' => \App\Http\Middleware\JwtMiddleware::class,
            'jwt.refresh' => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
            'jwt.verify' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 🔐 JWT Exceptions
        $exceptions->render(function (TokenExpiredException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired',
                'error_code' => 'TOKEN_EXPIRED'
            ], 401);
        });

        $exceptions->render(function (TokenInvalidException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid',
                'error_code' => 'TOKEN_INVALID'
            ], 401);
        });

        $exceptions->render(function (JWTException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token not provided',
                'error_code' => 'TOKEN_ABSENT'
            ], 401);
        });

        // 👤 Authentication & Authorization
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
                'error_code' => 'UNAUTHENTICATED'
            ], 401);
        });

        $exceptions->render(function (AuthorizationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden',
                'error_code' => 'FORBIDDEN'
            ], 403);
        });

        // 📝 Validation
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        });

        // 🔎 Model / Route Errors
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resource not found',
            ], 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Endpoint not found',
            ], 404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Method not allowed',
            ], 405);
        });

        // 🛑 Fallback
        $exceptions->render(function (\Throwable $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        });
    })
    ->create();
