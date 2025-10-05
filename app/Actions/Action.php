<?php
// app/Actions/Action.php

namespace App\Actions;

use Illuminate\Http\JsonResponse;
use App\Enums\Status; // Import your Status enum/class

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

    protected function success($data = null, string $message = '', int $code = Status::OK): JsonResponse
    {
        // For 204 No Content, return empty body
        if ($code === Status::NO_CONTENT) {
            return response()->json(null, $code);
        }

        return response()->json([
            'status'  => $code,
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }


    protected function error(string $message = '', int $code = Status::BAD_REQUEST, $errors = null): JsonResponse
    {
        return response()->json([
            'status'  => $code,
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
