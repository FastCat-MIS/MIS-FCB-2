<?php
// app/Http/Controllers/Operations/Vehicles/VehicleTypeController.php

namespace App\Http\Controllers\Operations\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\VehicleType;
use App\Actions\Operations\Vehicles\VehicleType\IndexVehicleTypeAction;
use App\Actions\Operations\Vehicles\VehicleType\ShowVehicleTypeAction;
use App\Actions\Operations\Vehicles\VehicleType\StoreVehicleTypeAction;
use App\Actions\Operations\Vehicles\VehicleType\UpdateVehicleTypeAction;
use App\Actions\Operations\Vehicles\VehicleType\DestroyVehicleTypeAction;

class VehicleTypeController extends Controller
{
    public function index(IndexVehicleTypeAction $action)
    {
        return $action->execute();
    }

    public function show(VehicleType $vehicleType, ShowVehicleTypeAction $action)
    {
        return $action->execute($vehicleType);
    }

    public function store(Request $request, StoreVehicleTypeAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, VehicleType $vehicleType, UpdateVehicleTypeAction $action)
    {
        return $action->execute($vehicleType, $request->all());
    }

    public function destroy(VehicleType $vehicleType, DestroyVehicleTypeAction $action)
    {
        return $action->execute($vehicleType);
    }
}
