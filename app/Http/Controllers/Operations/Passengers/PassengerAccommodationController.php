<?php

namespace App\Http\Controllers\Operations\Passengers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\PassengerAccommodation;
use App\Actions\Operations\Passengers\PassengerAccommodation\GetPassengerAccommodationsAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\GetPassengerAccommodationAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\CreatePassengerAccommodationAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\UpdatePassengerAccommodationAction;
use App\Actions\Operations\Passengers\PassengerAccommodation\DeletePassengerAccommodationAction;

class PassengerAccommodationController extends Controller
{
    public function index()
    {
        $accommodations = PassengerAccommodation::all();
        return response()->json([
            'data' => $accommodations,
            'message' => 'Passenger accommodations retrieved successfully.',
        ]);
    }

    public function show(PassengerAccommodation $passengerAccommodation)
    {
        return response()->json([
            'data' => $passengerAccommodation,
            'message' => 'Passenger accommodation retrieved successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'accommodation_name' => 'required|string|max:255',
        ]);

        $accommodation = PassengerAccommodation::create($validated);

        return response()->json([
            'data' => $accommodation,
            'message' => 'Passenger accommodation created successfully.',
        ], 201);
    }

    public function update(Request $request, PassengerAccommodation $passengerAccommodation)
    {
        $validated = $request->validate([
            'accommodation_name' => 'required|string|max:255',
        ]);

        $passengerAccommodation->update($validated);

        return response()->json([
            'data' => $passengerAccommodation,
            'message' => 'Passenger accommodation updated successfully.',
        ]);
    }

    public function destroy(PassengerAccommodation $passengerAccommodation)
    {
        $passengerAccommodation->delete();

        return response()->json([
            'message' => 'Passenger accommodation deleted successfully.',
        ]);
    }
}
