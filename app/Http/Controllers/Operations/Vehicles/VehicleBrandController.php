<?php
// app/Http/Controllers/Operations/Vehicles/VehicleBrandController.php

namespace App\Http\Controllers\Operations\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\VehicleBrand;
use App\Actions\Operations\Vehicles\VehicleBrand\IndexVehicleBrandAction;
use App\Actions\Operations\Vehicles\VehicleBrand\ShowVehicleBrandAction;
use App\Actions\Operations\Vehicles\VehicleBrand\StoreVehicleBrandAction;
use App\Actions\Operations\Vehicles\VehicleBrand\UpdateVehicleBrandAction;
use App\Actions\Operations\Vehicles\VehicleBrand\DestroyVehicleBrandAction;

class VehicleBrandController extends Controller
{
    public function index(IndexVehicleBrandAction $action)
    {
        return $action->execute();
    }

    public function show(VehicleBrand $vehicleBrand, ShowVehicleBrandAction $action)
    {
        return $action->execute($vehicleBrand);
    }

    public function store(Request $request, StoreVehicleBrandAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, VehicleBrand $vehicleBrand, UpdateVehicleBrandAction $action)
    {
        return $action->execute($vehicleBrand, $request->all());
    }

    public function destroy(VehicleBrand $vehicleBrand, DestroyVehicleBrandAction $action)
    {
        return $action->execute($vehicleBrand);
    }
}
