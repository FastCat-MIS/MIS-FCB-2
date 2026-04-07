<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Vessels\GetVesselsAction;
use App\Actions\Operations\Vessels\GetVesselsWithSchedAction;
use App\Actions\Operations\Vessels\GetVesselAction;
use App\Actions\Operations\Vessels\CreateVesselAction;
use App\Actions\Operations\Vessels\UpdateVesselAction;
use App\Actions\Operations\Vessels\DeleteVesselAction;

use App\Models\Operations\Vessel;
use Illuminate\Http\Request;

class VesselController extends Controller
{
    public function index(GetVesselsAction $action)
    {
        return $action->execute();
    }

    public function indexWithSched(GetVesselsWithSchedAction $action)
    {
        return $action->execute();
    }

    public function show(Vessel $vessel, GetVesselAction $action)
    {
        return $action->execute($vessel);
    }

    public function store(Request $request, CreateVesselAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, Vessel $vessel, UpdateVesselAction $action)
    {
        return $action->execute($vessel, $request->all());
    }

    public function destroy(Vessel $vessel, DeleteVesselAction $action)
    {
        return $action->execute($vessel);
    }
}
