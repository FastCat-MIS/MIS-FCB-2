<?php
// app/Http/Controllers/Marketing/addOnController.php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Actions\Marketing\AddOn\GetAddOnsAction;
use App\Actions\Marketing\AddOn\GetAddOnAction;
use App\Actions\Marketing\AddOn\CreateAddOnAction;
use App\Actions\Marketing\AddOn\UpdateAddOnAction;
use App\Actions\Marketing\AddOn\DeleteAddOnAction;
use App\Models\Marketing\AddOn;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
      /**
     * Display a listing of addOns.
     */
    public function index(GetAddOnsAction $getAddOnsAction)
    {
        return $getAddOnsAction->execute();
    }

    /**
     * Display the specified addOn.
     */

    public function show(AddOn $addOn, GetAddOnAction $getAddOnAction)
    {
        return $getAddOnAction->execute($addOn);
    }

    // /**
    //  * Store a newly created addOn.
    //  */

    public function store(Request $request, CreateAddOnAction $createAddOnAction)
    {
        return $createAddOnAction->execute($request->all());
    }

    // /**
    //  * Update the specified addOn.
    //  */

    public function update(Request $request, AddOn $addOn, UpdateAddOnAction $updateAddOnAction)
    {
        return $updateAddOnAction->execute($addOn, $request->all());
    }

    // /**
    //  * Remove the specified addOn.
    //  */


    public function destroy(AddOn $addOn, DeleteAddOnAction $deleteAddOnAction)
    {
        return $deleteAddOnAction->execute($addOn);
    }

}