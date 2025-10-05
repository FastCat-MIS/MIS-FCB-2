<?php
// app/Actions/Operations/Route/GetRoutesAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Exception;

class GetRoutesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $routes = Route::all();

            return $this->success([
                'routes' => $routes,
            ], 'Routes retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve routes: ' . $e->getMessage(), 500);
        }
    }
}
