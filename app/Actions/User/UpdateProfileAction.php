<?php
// app/Actions/User/UpdateProfileAction.php

namespace App\Actions\User;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateProfileAction extends Action
{
    public function execute(array $data)
    {
        $user = Auth::user();

        $validated = validator($data, [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'confirmed', 'min:8'],
        ])->validate();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return $this->success([
            'user' => $user->fresh(),
        ], 'Profile updated successfully');
    }
}
