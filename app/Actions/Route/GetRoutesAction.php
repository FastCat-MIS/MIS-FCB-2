<?php
// app/Actions/Route/GetRoutesAction.php

namespace App\Actions\Route;

use App\Actions\Action;
use App\Models\Operations\Route;

class GetRoutesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $routes = Route::all();

            return $this->success([
                'routes' => $routes,
            ], 'Routes retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve routes.', $e->getMessage());
        }
    }
}
