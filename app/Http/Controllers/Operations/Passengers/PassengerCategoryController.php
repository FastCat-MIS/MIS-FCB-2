<?php

namespace App\Http\Controllers\Operations\Passengers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\PassengerCategory;
use App\Actions\Operations\Passengers\PassengerCategory\GetPassengerCategoriesAction;
use App\Actions\Operations\Passengers\PassengerCategory\GetPassengerCategoryAction;
use App\Actions\Operations\Passengers\PassengerCategory\CreatePassengerCategoryAction;
use App\Actions\Operations\Passengers\PassengerCategory\UpdatePassengerCategoryAction;
use App\Actions\Operations\Passengers\PassengerCategory\DeletePassengerCategoryAction;

class PassengerCategoryController extends Controller
{
    public function index(GetPassengerCategoriesAction $action)
    {
        return $action->execute();
    }

    public function show(PassengerCategory $passengerCategory, GetPassengerCategoryAction $action)
    {
        return $action->execute($passengerCategory);
    }

    public function store(Request $request, CreatePassengerCategoryAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, PassengerCategory $passengerCategory, UpdatePassengerCategoryAction $action)
    {
        return $action->execute($passengerCategory, $request->all());
    }

    public function destroy(PassengerCategory $passengerCategory, DeletePassengerCategoryAction $action)
    {
        return $action->execute($passengerCategory);
    }
}
