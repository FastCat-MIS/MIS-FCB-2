<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\BookedPassenger;
use App\Actions\Operations\BookedPassenger\GetBookedPassengersAction;
use App\Actions\Operations\BookedPassenger\GetBookedPassengerAction;
use App\Actions\Operations\BookedPassenger\CreateBookedPassengerAction;
use App\Actions\Operations\BookedPassenger\UpdateBookedPassengerAction;
use App\Actions\Operations\BookedPassenger\DeleteBookedPassengerAction;
use App\Actions\Operations\BookedPassenger\GetBookedPassengerByKeywordAction;

class BookedPassengerController extends Controller
{
    public function index(GetBookedPassengersAction $action)
    {
        return $action->execute();
    }

    public function show(BookedPassenger $bookedPassenger, GetBookedPassengerAction $action)
    {
        return $action->execute($bookedPassenger);
    }

    public function store(Request $request, CreateBookedPassengerAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, BookedPassenger $bookedPassenger, UpdateBookedPassengerAction $action)
    {
        return $action->execute($bookedPassenger, $request->all());
    }

    public function destroy(BookedPassenger $bookedPassenger, DeleteBookedPassengerAction $action)
    {
        return $action->execute($bookedPassenger);
    }

    /**
     * Search booked passengers by keyword (fullname or booking number).
     */
    public function searchByKeyword(Request $request, GetBookedPassengerByKeywordAction $action)
    {
        $keyword = $request->query('keyword');

        if (!$keyword) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Keyword query parameter is required.',
            ], 400);
        }

        return $action->execute($keyword);
    }
}
