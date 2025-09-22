<?php
// app/Actions/Action.php

namespace App\Actions;

use Illuminate\Http\JsonResponse;

abstract class Action
{
    // Remove the abstract method to allow flexible signatures in child classes

    public static function make(): static
    {
        return app(static::class);
    }

    public function run(): mixed
    {
        return call_user_func_array([$this, 'execute'], func_get_args());
    }

    protected function success($data = null, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(string $message = '', int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
