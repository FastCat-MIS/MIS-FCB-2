<?php
// app/Http/Controllers/Operations/Vehicles/VehicleGroupController.php

namespace App\Http\Controllers\Operations\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\VehicleGroup;
use App\Actions\Operations\Vehicles\VehicleGroup\IndexVehicleGroupAction;
use App\Actions\Operations\Vehicles\VehicleGroup\ShowVehicleGroupAction;
use App\Actions\Operations\Vehicles\VehicleGroup\StoreVehicleGroupAction;
use App\Actions\Operations\Vehicles\VehicleGroup\UpdateVehicleGroupAction;
use App\Actions\Operations\Vehicles\VehicleGroup\DestroyVehicleGroupAction;

class VehicleGroupController extends Controller
{
    public function index(IndexVehicleGroupAction $action)
    {
        return $action->execute();
    }

    public function show(VehicleGroup $vehicleGroup, ShowVehicleGroupAction $action)
    {
        return $action->execute($vehicleGroup);
    }

    public function store(Request $request, StoreVehicleGroupAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, VehicleGroup $vehicleGroup, UpdateVehicleGroupAction $action)
    {
        return $action->execute($vehicleGroup, $request->all());
    }

    public function destroy(VehicleGroup $vehicleGroup, DestroyVehicleGroupAction $action)
    {
        return $action->execute($vehicleGroup);
    }
}
