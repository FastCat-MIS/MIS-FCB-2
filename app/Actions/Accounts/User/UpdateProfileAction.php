<?php

namespace App\Actions\Accounts\User;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;

class UpdateProfileAction extends Action
{
    public function execute(array $data): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            throw new AuthenticationException('User not authenticated.');
        }

        $validated = validator($data, [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'confirmed', 'min:8'],
        ])->validate();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        try {
            $user->update($validated);

            return $this->success([
                'user' => $user->fresh(),
            ], 'Profile updated successfully');
        } catch (QueryException $e) {
            throw new \RuntimeException('Failed to update profile. Please try again.');
        }
    }
}
