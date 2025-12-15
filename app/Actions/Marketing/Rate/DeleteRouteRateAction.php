<?php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Operations\Route;
use App\Models\Marketing\Rate;
use RuntimeException;

class DeleteRouteRateAction extends Action
{
    public function execute(Route $route, Rate $rate)
    {
        // ❗ Ensure rate belongs to the route
        if ($rate->route_id !== $route->route_id) {
            throw new RuntimeException('Rate does not belong to this route.', 403);
        }

        try {
            $rate->delete();

            return $this->success(
                [],
                'Rate deleted successfully',
                204
            );
        } catch (\Exception $e) {
            throw new RuntimeException(
                'Failed to delete rate.',
                500
            );
        }
    }
}
