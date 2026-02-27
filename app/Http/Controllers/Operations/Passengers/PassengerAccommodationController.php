<?php

namespace App\Http\Controllers\Operations\Passengers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\PassengerAccommodation;
use App\Actions\Operations\Passengers\PassengerAccommodation\CreatePassengerAccommodationAction;

class PassengerAccommodationController extends Controller
{
    // public function index()
    // {
    //     $accommodations = PassengerAccommodation::all();
    //     return response()->json([
    //         'data' => $accommodations,
    //         'message' => 'Passenger accommodations retrieved successfully.',
    //     ]);
    // }

    // public function show(PassengerAccommodation $passengerAccommodation)
    // {
    //     return response()->json([
    //         'data' => $passengerAccommodation,
    //         'message' => 'Passenger accommodation retrieved successfully.',
    //     ]);
    // }

    // public function store(Request $request, CreatePassengerAccommodationAction $action)
    // {
    //     return $action->execute($request->all());
    // }

    // public function update(Request $request, PassengerAccommodation $passengerAccommodation)
    // {
    //     $validated = $request->validate([
    //         'accommodation_name' => 'required|string|max:255',
    //     ]);

    //     $passengerAccommodation->update($validated);

    //     return response()->json([
    //         'data' => $passengerAccommodation,
    //         'message' => 'Passenger accommodation updated successfully.',
    //     ]);
    // }

    // public function destroy(PassengerAccommodation $passengerAccommodation)
    // {
    //     $passengerAccommodation->delete();

    //     return response()->json([
    //         'message' => 'Passenger accommodation deleted successfully.',
    //     ]);
    // }
}
