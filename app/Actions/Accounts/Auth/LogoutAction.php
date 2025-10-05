<?php

namespace App\Actions\Accounts\Auth;

use App\Actions\Action;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class LogoutAction extends Action
{
    public function execute(array $data = []): JsonResponse
    {
        // Will throw if token is invalid or missing — global handler will catch
        $token = JWTAuth::getToken();

        JWTAuth::invalidate($token); // May throw TokenInvalidException, TokenExpiredException, etc.

        return $this->success(null, 'Successfully logged out');
    }
}
