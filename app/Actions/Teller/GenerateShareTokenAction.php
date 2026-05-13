<?php

namespace App\Actions\Teller;

use App\Actions\Action;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Accounts\User;

class GenerateShareTokenAction extends Action
{
    public function execute(): array
    {
        // Create a temporary user for sharing (or use a system user)
        // For security, you might want to create a dedicated "share" user
        $shareUser = User::firstOrCreate(
            ['email' => 'share@fastcat.com'],
            [
                'name' => 'Share User',
                'password' => bcrypt(uniqid()), // Random password
                'email_verified_at' => now(),
            ]
        );

        // Generate a JWT token for this user
        // Set custom claims if needed for tracking
        $token = JWTAuth::customClaims([
            'purpose' => 'payment_sharing',
            'generated_at' => now()->toISOString(),
        ])->fromUser($shareUser);

        return [
            'token' => 'Bearer ' . $token,
            'expires_in' => null, // Or set a very long expiration
            'purpose' => 'Payment data sharing',
            'generated_at' => now()->toISOString(),
        ];
    }
}