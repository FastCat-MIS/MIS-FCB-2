<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Vessels\GetVesselsAction;
use App\Actions\Operations\Vessels\GetVesselAction;
use App\Actions\Operations\Vessels\CreateVesselAction;
use App\Actions\Operations\Vessels\UpdateVesselAction;
use App\Actions\Operations\Vessels\DeleteVesselAction;

use App\Models\Operations\Vessel;
use Illuminate\Http\Request;

class VesselController extends Controller
{
    public function index(GetVesselsAction $getVesselsAction)
    {
        return $getVesselsAction->execute();
    }

    public function show(Vessel $vessel, GetVesselAction $getVesselAction)
    {
        return $getVesselAction->execute($vessel);
    }

    public function store(Request $request, CreateVesselAction $createVesselAction)
    {
        return $createVesselAction->execute($request->all());
    }

    public function update(Request $request, Vessel $vessel, UpdateVesselAction $updateVesselAction)
    {
        return $updateVesselAction->execute($vessel, $request->all());
    }

    public function destroy(Vessel $vessel, DeleteVesselAction $deleteVesselAction)
    {
        return $deleteVesselAction->execute($vessel);
    }
}
