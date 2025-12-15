<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Operations\Route;
use App\Models\Marketing\Rate;
use Illuminate\Http\Request;

use App\Actions\Marketing\Rate\{
    GetRouteRatesAction,
    CreateRouteRateAction,
    UpdateRouteRateAction,
    DeleteRouteRateAction
};

class RouteRateController extends Controller
{
    public function index(Route $route, GetRouteRatesAction $action)
    {
        return $action->execute($route);
    }

    public function store(Route $route, Request $request, CreateRouteRateAction $action)
    {
        return $action->execute($route, $request->all());
    }

    /**
     * BULK UPDATE
     */
    public function update(
        Route $route,
        Request $request,
        UpdateRouteRateAction $action
    ) {
        return $action->execute($route, $request->all());
    }

    /**
     * SINGLE DELETE (unchanged)
     */
    public function destroy(
        Route $route,
        Rate $rate,
        DeleteRouteRateAction $action
    ) {
        return $action->execute($route, $rate);
    }
}
