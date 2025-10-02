<?php
// app/Http/Controllers/Marketing/RateController.php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Actions\Marketing\Rate\GetRatesAction;
use App\Actions\Marketing\Rate\GetRateAction;
use App\Actions\Marketing\Rate\CreateRateAction;
use App\Actions\Marketing\Rate\UpdateRateAction;
use App\Actions\Marketing\Rate\DeleteRateAction;
use App\Models\Marketing\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of rates.
     */
    public function index(GetRatesAction $getRatesAction)
    {
        return $getRatesAction->execute();
    }

    /**
     * Display the specified rate.
     */
    public function show(Rate $rate, GetRateAction $getRateAction)
    {
        return $getRateAction->execute($rate);
    }

    /**
     * Store a newly created rate.
     */
    public function store(Request $request, CreateRateAction $createRateAction)
    {
        return $createRateAction->execute($request->all());
    }

    /**
     * Update the specified rate.
     */
    public function update(Request $request, Rate $rate, UpdateRateAction $updateRateAction)
    {
        return $updateRateAction->execute($rate, $request->all());
    }

    /**
     * Remove the specified rate.
     */
    public function destroy(Rate $rate, DeleteRateAction $deleteRateAction)
    {
        return $deleteRateAction->execute($rate);
    }
}
