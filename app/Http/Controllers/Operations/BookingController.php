<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\Booking;
use App\Actions\Operations\Booking\GetBookingsAction;
use App\Actions\Operations\Booking\GetBookingAction;
use App\Actions\Operations\Booking\CreateBookingAction;
use App\Actions\Operations\Booking\UpdateBookingAction;
use App\Actions\Operations\Booking\DeleteBookingAction;
use App\Actions\Operations\Booking\GetBookingByKeywordAction;

class BookingController extends Controller
{
    public function index(GetBookingsAction $getBookingsAction)
    {
        return $getBookingsAction->execute();
    }

    public function show(Booking $booking, GetBookingAction $getBookingAction)
    {
        return $getBookingAction->execute($booking);
    }

    public function store(Request $request, CreateBookingAction $createBookingAction)
    {
        return $createBookingAction->execute($request->all());
    }

    public function update(Request $request, Booking $booking, UpdateBookingAction $updateBookingAction)
    {
        return $updateBookingAction->execute($booking, $request->all());
    }

    public function destroy(Booking $booking, DeleteBookingAction $deleteBookingAction)
    {
        return $deleteBookingAction->execute($booking);
    }

    public function searchByKeyword(Request $request, GetBookingByKeywordAction $action)
    {
        $keyword = $request->query('keyword');
        return $action->execute($keyword);
    }

}
