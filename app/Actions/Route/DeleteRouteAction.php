<?php
// app/Actions/Route/DeleteRouteAction.php

namespace App\Actions\Route;

use App\Actions\Action;
use App\Models\Operations\Route;

class DeleteRouteAction extends Action
{
    public function execute(Route $route)
    {
        try {
            // Check if route has related records
            if ($route->rates()->count() > 0 || $route->schedules()->count() > 0) {
                return $this->error('Cannot delete route. It has associated rates or schedules.');
            }

            $route->delete();

            return $this->success([], 'Route deleted successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to delete route.', $e->getMessage());
        }
    }
}
