<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\Operations\Vessel;
use Illuminate\Http\Request;
use App\Actions\Operations\VesselLayout\{
    StoreVesselLayoutAction,
    GetVesselLayoutAction,
    DeleteVesselLayoutAction
};

class VesselLayoutController extends Controller
{
    public function show(
        Vessel $vessel,
        GetVesselLayoutAction $action
    ) {
        return response()->json($action->execute($vessel));
    }

    public function store(
        Request $request,
        Vessel $vessel,
        StoreVesselLayoutAction $action
    ) {
        return response()->json(
            $action->execute($vessel, $request->all()),
            201
        );
    }

    public function update(
        Request $request,
        Vessel $vessel,
        StoreVesselLayoutAction $action
    ) {
        return response()->json(
            $action->execute($vessel, $request->all())
        );
    }

    public function destroy(
        Vessel $vessel,
        DeleteVesselLayoutAction $action
    ) {
        return response()->json(
            $action->execute($vessel)
        );
    }
}
