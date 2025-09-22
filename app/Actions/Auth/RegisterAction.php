<?php

namespace App\Actions\Auth;

use App\Actions\Action;
use App\Models\Accounts\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RegisterAction extends Action
{
    public function execute(array $data = []): JsonResponse
    {
        $validated = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'], // Added middle_name
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'role_id' => ['nullable', 'integer', 'exists:roles,id']
        ])->validate();

        // Set default role_id to customer (usually role_id = 5) if not provided
        $roleId = $validated['role_id'] ?? 5;

        $user = User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null, // Added middle_name
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role_id' => $roleId,
            'status' => 'active'
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);
        $bearerToken = 'Bearer ' . $token;

        return $this->success([
            'user' => [
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name, // Added middle_name
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'role_id' => $user->role_id,
                'status' => $user->status,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'full_name' => $user->full_name,
                'short_name' => $user->short_name
            ],
            'token' => $bearerToken,
            'token_type' => 'Bearer'
        ], 'User registered successfully', 201);
    }
}
