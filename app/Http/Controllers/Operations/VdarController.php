<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Vdar\GetVdarsAction;
use App\Actions\Operations\Vdar\GetVdarAction;
use App\Actions\Operations\Vdar\GetVdarsByVesselAction;
use App\Actions\Operations\Vdar\CreateVdarAction;
use App\Actions\Operations\Vdar\UpdateVdarAction;
use App\Actions\Operations\Vdar\DeleteVdarAction;
use App\Models\Operations\Vdar;
use App\Models\Operations\Vessel;
use Illuminate\Http\Request;

class VdarController extends Controller
{
    public function index(GetVdarsAction $action)
    {
        return $action->execute();
    }

    public function show(Vdar $vdar, GetVdarAction $action)
    {
        return $action->execute($vdar);
    }

    public function store(Request $request, CreateVdarAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, Vdar $vdar, UpdateVdarAction $action)
    {
        return $action->execute($vdar, $request->all());
    }

    public function destroy(Vdar $vdar, DeleteVdarAction $action)
    {
        return $action->execute($vdar);
    }

    public function byVessel(Vessel $vessel, GetVdarsByVesselAction $action)
    {
        return $action->execute($vessel);
    }
}
