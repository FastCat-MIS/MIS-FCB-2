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
    /**
     * Display a listing of the passenger types.
     */
    public function index(GetPassengerTypesAction $getPassengerTypesAction)
    {
        return $getPassengerTypesAction->execute();
    }

    /**
     * Display the specified passenger type.
     */
    public function show(PassengerType $passengerType, GetPassengerTypeAction $getPassengerTypeAction)
    {
        return $getPassengerTypeAction->execute($passengerType);
    }

    /**
     * Store a newly created passenger type.
     */
    public function store(Request $request, CreatePassengerTypeAction $createPassengerTypeAction)
    {
        return $createPassengerTypeAction->execute($request->all());
    }

    /**
     * Update the specified passenger type.
     */
    public function update(Request $request, PassengerType $passengerType, UpdatePassengerTypeAction $updatePassengerTypeAction)
    {
        return $updatePassengerTypeAction->execute($passengerType, $request->all());
    }

    /**
     * Remove the specified passenger type.
     */
    public function destroy(PassengerType $passengerType, DeletePassengerTypeAction $deletePassengerTypeAction)
    {
        return $deletePassengerTypeAction->execute($passengerType);
    }
}
