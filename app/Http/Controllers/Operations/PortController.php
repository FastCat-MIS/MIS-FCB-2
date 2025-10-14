<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\Port;
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

    public function show(Port $port, GetPortAction $action)
    {
        return $action->execute($port);
    }

    public function store(Request $request, CreatePortAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, Port $port, UpdatePortAction $action)
    {
        return $action->execute($port, $request->all());
    }

    public function destroy(Port $port, DeletePortAction $action)
    {
        return $action->execute($port);
    }
}
