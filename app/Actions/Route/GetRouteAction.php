<?php
// app/Actions/Route/GetRouteAction.php

namespace App\Actions\Route;

use App\Actions\Action;
use App\Models\Operations\Route;

class GetRouteAction extends Action
{
    public function execute(Route $route, array $data = [])
    {
        try {
            $route->load('rates', 'schedules');

            return $this->success([
                'route' => $route,
            ], 'Route retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve route.', $e->getMessage());
        }
    }
}
