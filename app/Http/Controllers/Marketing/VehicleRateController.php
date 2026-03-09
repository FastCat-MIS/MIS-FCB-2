<?php
// app/Http/Controllers/Marketing/RateController.php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Actions\Marketing\Rate\VehicleRates\CreateVehicleRateAction;
use App\Actions\Marketing\Rate\VehicleRates\GetVehicleRateAction;
use App\Actions\Marketing\Rate\VehicleRates\GetVehicleRatesAction;

use App\Actions\Marketing\Rate\VehicleRates\UpdateVehicleRateAction;
use App\Actions\Marketing\Rate\VehicleRates\DeleteVehicleRateAction;
use App\Actions\Marketing\Rate\VehicleRates\GetRouteVehicleRatesAction;
use Illuminate\Http\Request;

class VehicleRateController extends Controller
{
    /**
     * Display a listing of rates.
     */
    public function index(GetVehicleRatesAction $getVehicleRatesAction)
    {
        return $getVehicleRatesAction->execute();
    }

    /**
     * Display the specified rate.
     */
    public function show($vehicleRateId, GetVehicleRateAction $getVehicleRateAction)
    {
        return $getVehicleRateAction->execute($vehicleRateId);
    }


    public function showRoute($routeId, GetRouteVehicleRatesAction $action)
    {
        return $action->execute($routeId);
    }

    /**
     * Store a newly created rate.
     */
    public function store(Request $request, CreateVehicleRateAction $createVehicleRateAction)
    {
        return $createVehicleRateAction->execute($request->all());
    }

    /**
     * Update the specified rate.
     */
    public function update(Request $request, $vehicleRateId, UpdateVehicleRateAction $updateVehicleRateAction)
    {
        return $updateVehicleRateAction->execute($vehicleRateId, $request->all());
    }

    /**
     * Remove the specified rate.
     */
    public function destroy($vehicleRateId, DeleteVehicleRateAction $deleteVehicleRateAction)
    {
        return $deleteVehicleRateAction->execute($vehicleRateId);
    }
}
