<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\BookedPassenger\CreateBookedPassengerAction;
use App\Actions\Teller\BookedPassenger\DeleteBookedPassengerAction;
use App\Actions\Teller\BookedPassenger\GetBookedPassengerAction;
use App\Actions\Teller\BookedPassenger\GetBookedPassengersAction;
use App\Actions\Teller\BookedPassenger\UpdateBookedPassengerAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookedPassengerController extends Controller
{
    public function index(GetBookedPassengersAction $action)
    {
        return $action->execute();
    }

    public function show(int $bookedPassengerId, GetBookedPassengerAction $action)
    {
        return $action->execute($bookedPassengerId);
    }

    public function store(Request $request, CreateBookedPassengerAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, int $bookedPassengerId, UpdateBookedPassengerAction $action)
    {
        return $action->execute($bookedPassengerId, $request->all());
    }

    public function destroy(int $bookedPassengerId, DeleteBookedPassengerAction $action)
    {
        return $action->execute($bookedPassengerId);
    }
}

