<?php

namespace App\Actions\Operations\Route;

use App\Actions\Action;
use App\Models\Operations\Route;
use Exception;

class DeleteRouteAction extends Action
{
    public function execute(Route $route)
    {
        try {
            // Optional: check for related records before deletion
            // if ($route->rates()->count() > 0 || $route->schedules()->count() > 0) {
            //     throw new Exception('Cannot delete route. It has associated rates or schedules.', 422);
            // }

            $route->delete();

            return $this->success([], 'Route deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new Exception('Failed to delete route: ' . $e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
