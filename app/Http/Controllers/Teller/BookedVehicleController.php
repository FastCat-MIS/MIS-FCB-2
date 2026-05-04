<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\BookedVehicle\CreateBookedVehicleAction;
use App\Actions\Teller\BookedVehicle\DeleteBookedVehicleAction;
use App\Actions\Teller\BookedVehicle\GetBookedVehicleAction;
use App\Actions\Teller\BookedVehicle\GetBookedVehiclesAction;
use App\Actions\Teller\BookedVehicle\UpdateBookedVehicleAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookedVehicleController extends Controller
{
    public function index(GetBookedVehiclesAction $action)
    {
        return $action->execute();
    }

    public function show(int $bookedVehicleId, GetBookedVehicleAction $action)
    {
        return $action->execute($bookedVehicleId);
    }

    public function store(Request $request, CreateBookedVehicleAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, int $bookedVehicleId, UpdateBookedVehicleAction $action)
    {
        return $action->execute($bookedVehicleId, $request->all());
    }

    public function destroy(int $bookedVehicleId, DeleteBookedVehicleAction $action)
    {
        return $action->execute($bookedVehicleId);
    }
}

