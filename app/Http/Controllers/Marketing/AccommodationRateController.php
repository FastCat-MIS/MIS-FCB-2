<?php
// app/Http/Controllers/Marketing/RateController.php

namespace App\Http\Controllers\Marketing;

use App\Actions\Marketing\Rate\AccommodationRates\GetAccommodationRatesAction;
use App\Actions\Marketing\Rate\AccommodationRates\GetAccommodationRateAction;
use App\Actions\Marketing\Rate\AccommodationRates\GetRouteAccRatesAction;
use App\Actions\Marketing\Rate\AccommodationRates\UpdateAccommodationRateAction;
use App\Http\Controllers\Controller;

use App\Models\Marketing\AccommodationRate;
use Illuminate\Http\Request;

class AccommodationRateController extends Controller
{
    /**
     * Display a listing of rates.
     */
    public function index(GetAccommodationRatesAction $action)
    {
        return $action->execute();
    }

    /**
     * Display the specified rate.
     */
    public function show($accRateId, GetAccommodationRateAction $action)
    {
        return $action->execute($accRateId);
    }

    public function showRoute($routeId, GetRouteAccRatesAction $action)
    {
        return $action->execute($routeId);
    }

    /**
     * Store a newly created rate.
     */
    
    // public function store(Request $request, CreateRateAction $createRateAction)
    // {
    //     return $createRateAction->execute($request->all());
    // }

    /**
     * Update the specified rate.
     */
    public function update(Request $request, $accRate, UpdateAccommodationRateAction $action)
    {
        return $action->execute($accRate, $request->all());
    }

    /**
     * Remove the specified rate.
     */
    // public function destroy(Rate $rate, DeleteRateAction $deleteRateAction)
    // {
    //     return $deleteRateAction->execute($rate);
    // }
}