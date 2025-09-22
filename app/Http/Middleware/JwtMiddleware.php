<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        // Extract token from Authorization header
        $token = $this->extractToken($request);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authorization token not provided',
                'error_code' => 'TOKEN_ABSENT'
            ], 401);
        }

        try {
            // Set the token for JWT auth
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                    'error_code' => 'USER_NOT_FOUND'
                ], 404);
            }

            // Add user to request
            $request->merge(['user' => $user]);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expired',
                'error_code' => 'TOKEN_EXPIRED'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token invalid',
                'error_code' => 'TOKEN_INVALID'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token authentication failed',
                'error_code' => 'TOKEN_AUTH_FAILED'
            ], 401);
        }

        return $next($request);
    }

    /**
     * Extract token from Authorization header
     * Handles both "Bearer token" and raw token formats
     */
    private function extractToken($request)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader) {
            return null;
        }

        // Check if header contains "Bearer "
        if (str_starts_with($authorizationHeader, 'Bearer ')) {
            return substr($authorizationHeader, 7); // Remove "Bearer " prefix
        }

        // Return raw token if no "Bearer " prefix
        return $authorizationHeader;
    }
}
