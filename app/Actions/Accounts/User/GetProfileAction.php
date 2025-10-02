<?php
// app/Actions/Accounts/User/GetProfileAction.php

namespace App\Actions\Accounts\User;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class GetProfileAction extends Action
{
    public function execute(array $data = [])
    {
        $user = Auth::user();

        return $this->success([
            'user' => $user,
        ], 'Profile retrieved successfully');
    }
}
