<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Marketing\AccommodationRate;
use App\Actions\Marketing\Rate\AccommodationRates\CreateAccommodationRateAction;
use Illuminate\Http\Request;

class AccommodationRateController extends Controller
{
      /**
     * Display a listing of addOns.
     */
    // public function index(GetAddOnsAction $getAddOnsAction)
    // {
    //     return $getAddOnsAction->execute();
    // }

    /**
     * Display the specified addOn.
     */

    // public function show(AddOn $addOn, GetAddOnAction $getAddOnAction)
    // {
    //     return $getAddOnAction->execute($addOn);
    // }

    // /**
    //  * Store a newly created addOn.
    //  */

    public function store(Request $request, CreateAccommodationRateAction $action)
    {
        return $action->execute($request->all());
    }

    // /**
    //  * Update the specified addOn.
    //  */

    // public function update(Request $request, AddOn $addOn, UpdateAddOnAction $updateAddOnAction)
    // {
    //     return $updateAddOnAction->execute($addOn, $request->all());
    // }

    // /**
    //  * Remove the specified addOn.
    //  */


    // public function destroy(AddOn $addOn, DeleteAddOnAction $deleteAddOnAction)
    // {
    //     return $deleteAddOnAction->execute($addOn);
    // }

}