<?php

namespace App\Actions\Accounts\User;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class GetProfileAction extends Action
{
    public function execute(array $data = [])
    {
        $user = Auth::user();

        if (!$user) {
            throw new AuthenticationException('User not authenticated.');
        }

        return $this->success([
            'user' => $user,
        ], 'Profile retrieved successfully');
    }
}
