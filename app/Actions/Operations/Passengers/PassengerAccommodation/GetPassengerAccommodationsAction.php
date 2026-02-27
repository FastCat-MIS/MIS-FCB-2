<?php

namespace App\Actions\Operations\Passengers\PassengerAccommodation;

use App\Actions\Action;
use App\Models\Operations\PassengerAccommodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class GetPassengerAccommodationsAction extends Action
{
    public function execute()
    {
        $accommodations = PassengerAccommodation::all();
        return response()->json([
          'data' => $accommodations,
          'message' => 'Passenger accommodations retrieved successfully.',
        ]);
    }
}