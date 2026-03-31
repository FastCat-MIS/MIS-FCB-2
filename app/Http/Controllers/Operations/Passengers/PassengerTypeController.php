<?php

namespace App\Http\Controllers\Operations\Passengers;

use App\Http\Controllers\Controller;
use App\Actions\Operations\Passengers\PassengerType\GetPassengerTypesAction;
use App\Actions\Operations\Passengers\PassengerType\GetPassengerTypeAction;
use App\Actions\Operations\Passengers\PassengerType\CreatePassengerTypeAction;
use App\Actions\Operations\Passengers\PassengerType\UpdatePassengerTypeAction;
use App\Actions\Operations\Passengers\PassengerType\DeletePassengerTypeAction;
use App\Models\Operations\PassengerType;
use Illuminate\Http\Request;

class PassengerTypeController extends Controller
{

    public function index(GetPassengerTypesAction $action)
    {
        return $action->execute();
    }

    public function show(PassengerType $passengerType, GetPassengerTypeAction $action)
    {
        return $action->execute($passengerType);
    }

    public function store(Request $request, CreatePassengerTypeAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, PassengerType $passengerType, UpdatePassengerTypeAction $action)
    {
        return $action->execute($passengerType, $request->all());
    }

    public function destroy(PassengerType $passengerType, DeletePassengerTypeAction $action)
    {
        return $action->execute($passengerType);
    }
}
