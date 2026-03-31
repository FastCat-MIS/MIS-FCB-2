<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Operations\Ports\{
    GetPortsAction,
    GetPortAction,
    CreatePortAction,
    UpdatePortAction,
    DeletePortAction
};

class PortController extends Controller
{
    public function index(GetPortsAction $action)
    {
        return $action->execute();
    }

    public function show($portId, GetPortAction $action)
    {
        return $action->execute($portId);
    }

    public function store(Request $request, CreatePortAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, $portId, UpdatePortAction $action)
    {
        return $action->execute($portId, $request->all());
    }

    public function destroy($portId, DeletePortAction $action)
    {
        return $action->execute($portId);
    }
}
