<?php

namespace App\Actions\Pem;

use App\Actions\Action;
use App\Models\PemClient;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;

class GeneratePemJwtAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'pem_public_key' => 'required|string',
            'signature' => 'required|string', // Client signs a nonce with their private key
            'nonce' => 'required|string|size:32', // Server-provided nonce
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Find PEM client by fingerprint
        $pemFingerprint = $this->generatePemFingerprint($validated['pem_public_key']);
        $pemClient = PemClient::where('pem_fingerprint', $pemFingerprint)
            ->where('is_active', true)
            ->first();

        if (!$pemClient) {
            return $this->error('PEM client not found or inactive', 404);
        }

        // Verify signature (this is a simplified version - you'd use openssl_verify in real implementation)
        $isSignatureValid = $this->verifySignature(
            $validated['pem_public_key'],
            $validated['signature'],
            $validated['nonce']
        );

        if (!$isSignatureValid) {
            return $this->error('Invalid signature', 401);
        }

        // Generate JWT token - use a real user from database for JWT generation
        // Find any user that can be used as a subject for JWT
        $user = \App\Models\Accounts\User::first();

        if (!$user) {
            return $this->error('No user found for JWT generation', 500);
        }

        // Generate token with custom claims using fromUser approach
        $token = JWTAuth::customClaims([
            'sub' => 'pem-client-' . $pemClient->pem_client_id, // Override subject
            'pem_client_id' => $pemClient->pem_client_id,
            'pem_fingerprint' => $pemFingerprint,
            'permissions' => $pemClient->permissions,
            'purpose' => 'pem_authentication',
        ])->fromUser($user);

        $tokenString = $token;

        $pemClient->markAsUsed();

        return $this->success([
            'access_token' => 'Bearer ' . $tokenString,
            'token_type' => 'Bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'permissions' => $pemClient->permissions,
        ], 'JWT token generated successfully');
    }

    private function generatePemFingerprint(string $pemPublicKey): string
    {
        $cleanPem = preg_replace('/-----.*-----/', '', $pemPublicKey);
        $cleanPem = preg_replace('/\s+/', '', $cleanPem);
        return hash('sha256', base64_decode($cleanPem));
    }

    private function verifySignature(string $pemPublicKey, string $signature, string $data): bool
    {
        // Get public key resource
        $publicKeyResource = openssl_pkey_get_public($pemPublicKey);

        if ($publicKeyResource === false) {
            // Log the error for debugging
            \Log::error('Failed to get public key resource: ' . openssl_error_string());
            return false;
        }

        // Decode the base64 signature
        $signatureDecoded = base64_decode($signature);

        if ($signatureDecoded === false) {
            \Log::error('Failed to decode base64 signature');
            openssl_free_key($publicKeyResource);
            return false;
        }

        // Verify the signature
        $isValid = openssl_verify($data, $signatureDecoded, $publicKeyResource, OPENSSL_ALGO_SHA256);

        // Free the key resource
        openssl_free_key($publicKeyResource);

        if ($isValid === 1) {
            return true; // Signature is valid
        } elseif ($isValid === 0) {
            \Log::warning('Invalid signature provided');
            return false; // Signature is invalid
        } else {
            \Log::error('OpenSSL verification error: ' . openssl_error_string());
            return false; // Error occurred during verification
        }
    }
}
