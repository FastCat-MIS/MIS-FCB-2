<?php

namespace App\Actions\Accounts\Auth;

use App\Actions\Action;
use App\Models\Accounts\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\AuthenticationException;

class LoginAction extends Action
{
    public function execute(array $data = []): JsonResponse
    {
        $validated = validator($data, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $token = JWTAuth::fromUser($user);

        $bearerToken = 'Bearer ' . $token;

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $bearerToken,
        ], 'Login successful');
    }
}
