<?php

namespace App\Http\Controllers\Operations\Passengers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Operations\Passengers\PassengerAccommodation\CreatePassengerAccommodationAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\GetPassengerAccommodationsAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\GetPassengerAccommodationAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\UpdatePassengerAccommodationAction;

class PassengerAccommodationController extends Controller
{
    public function index(GetPassengerAccommodationsAction $action )
    {
        return $action->execute();
    }

    public function show($accommodationId, GetPassengerAccommodationAction $action)
    {
        return $action->execute($accommodationId);
    }

    public function store(Request $request, CreatePassengerAccommodationAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, int $accommodationId, UpdatePassengerAccommodationAction $action)
    {
        return $action->execute($accommodationId, $request->all());
    }

    // public function destroy(PassengerAccommodation $passengerAccommodation)
    // {
    //     $passengerAccommodation->delete();

    //     return response()->json([
    //         'message' => 'Passenger accommodation deleted successfully.',
    //     ]);
    // }
}
