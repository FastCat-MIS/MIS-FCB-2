<?php

namespace App\Actions\Accounts\Auth;

use App\Actions\Action;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutAction extends Action
{
    public function execute(array $data = []): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->success(null, 'Successfully logged out');
    }
}
