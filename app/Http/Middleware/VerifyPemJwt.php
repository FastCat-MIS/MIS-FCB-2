<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\PemClient;
use Symfony\Component\HttpFoundation\Response;

class VerifyPemJwt
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        try {
            // Get JWT token
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            // Get token purpose and handle both authentication types
            $purpose = $payload->get('purpose');

            // Allow both PEM and standard authentication tokens
            if (!in_array($purpose, ['pem_authentication', 'standard_authentication'])) {
                return response()->json([
                    'status' => 401,
                    'success' => false,
                    'message' => 'Invalid token type',
                ], 401);
            }

            if ($purpose === 'pem_authentication') {
                // PEM authentication flow
                $pemClientId = $payload->get('pem_client_id');
                $pemFingerprint = $payload->get('pem_fingerprint');

                $pemClient = PemClient::where('pem_client_id', $pemClientId)
                    ->where('pem_fingerprint', $pemFingerprint)
                    ->where('is_active', true)
                    ->first();

                if (!$pemClient) {
                    return response()->json([
                        'status' => 401,
                        'success' => false,
                        'message' => 'PEM client not found or inactive',
                    ], 401);
                }

                // Check PEM client permissions
                if (!$pemClient->hasPermission($permission)) {
                    return response()->json([
                        'status' => 403,
                        'success' => false,
                        'message' => 'Insufficient permissions',
                    ], 403);
                }

                // Add PEM client to request for controller use
                $request->attributes->set('pem_client', $pemClient);
                $request->attributes->set('auth_type', 'pem');

            } else {
                // Standard authentication flow
                $userId = $payload->get('sub');

                // For standard authentication, we need to check user permissions
                // You'll need to implement your user permission checking logic here
                // This is a placeholder - replace with your actual user permission check
                $hasPermission = $this->checkUserPermission($userId, $permission);

                if (!$hasPermission) {
                    return response()->json([
                        'status' => 403,
                        'success' => false,
                        'message' => 'Insufficient permissions',
                    ], 403);
                }

                $request->attributes->set('auth_type', 'standard');
                $request->attributes->set('user_id', $userId);
            }

            return $next($request);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Token invalid or expired',
            ], 401);
        }
    }

    /**
     * Check if a standard user has the required permission
     * This is a placeholder - implement your actual user permission logic
     */
    private function checkUserPermission($userId, string $permission): bool
    {
        // TODO: Implement your actual user permission checking logic
        // For now, this returns true to allow access - replace with real implementation

        // Example implementation (you'll need to adjust this):
        // $user = \App\Models\User::find($userId);
        // return $user && $user->hasPermission($permission);

        return true; // Temporary - allows all standard users access
    }
}
