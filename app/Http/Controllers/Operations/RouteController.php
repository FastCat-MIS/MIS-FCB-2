<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Route\GetRoutesAction;
use App\Actions\Route\GetRouteAction;
use App\Actions\Route\CreateRouteAction;
use App\Actions\Route\UpdateRouteAction;
use App\Actions\Route\DeleteRouteAction;
use App\Models\Operations\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of routes.
     */
    public function index(GetRoutesAction $getRoutesAction)
    {
        return $getRoutesAction->execute();
    }

    /**
     * Display the specified route.
     */
    public function show(Route $route, GetRouteAction $getRouteAction)
    {
        return $getRouteAction->execute($route);
    }

    /**
     * Store a newly created route.
     */
    public function store(Request $request, CreateRouteAction $createRouteAction)
    {
        return $createRouteAction->execute($request->all());
    }

    /**
     * Update the specified route.
     */
    public function update(Request $request, Route $route, UpdateRouteAction $updateRouteAction)
    {
        return $updateRouteAction->execute($route, $request->all());
    }

    /**
     * Remove the specified route.
     */
    public function destroy(Route $route, DeleteRouteAction $deleteRouteAction)
    {
        return $deleteRouteAction->execute($route);
    }
}
