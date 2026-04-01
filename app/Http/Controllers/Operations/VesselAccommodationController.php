<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Vessels\VesselAccommodation\StoreVesselAccommodationAction;

use Illuminate\Http\Request;

class VesselAccommodationController extends Controller
{
    // public function index(GetVesselsAction $action)
    // {
    //     return $action->execute();
    // }

    // public function show(Vessel $vessel, GetVesselAction $action)
    // {
    //     return $action->execute($vessel);
    // }

    public function store(Request $request, $vesselId, StoreVesselAccommodationAction $action)
    {
        return $action->execute($vesselId, $request->all());
    }

    // public function update(Request $request, Vessel $vessel, UpdateVesselAction $action)
    // {
    //     return $action->execute($vessel, $request->all());
    // }

    // public function destroy(Vessel $vessel, DeleteVesselAction $action)
    // {
    //     return $action->execute($vessel);
    // }
}
