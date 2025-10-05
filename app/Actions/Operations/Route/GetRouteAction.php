<?php
// app/Actions/Operations/Route/GetRouteAction.php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Exception;

class GetRouteAction extends Action
{
    public function execute(Route $route, array $data = [])
    {
        try {
            // Optional: eager load relationships if needed
            // $route->load('rates', 'schedules');

            return $this->success([
                'route' => $route,
            ], 'Route retrieved successfully.');
        } catch (\Throwable $e) {
            throw new Exception('Failed to retrieve route: ' . $e->getMessage(), 500);
        }
    }
}
