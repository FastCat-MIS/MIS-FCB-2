<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operations\ConnectingTrip;
use App\Actions\Operations\ConnectingTrip\GetConnectingTripsAction;
use App\Actions\Operations\ConnectingTrip\GetConnectingTripAction;
use App\Actions\Operations\ConnectingTrip\GetConnectingTripByKeywordAction;
use App\Actions\Operations\ConnectingTrip\CreateConnectingTripAction;
use App\Actions\Operations\ConnectingTrip\UpdateConnectingTripAction;
use App\Actions\Operations\ConnectingTrip\DeleteConnectingTripAction;

class ConnectingTripController extends Controller
{
    /**
     * List all connecting trips
     */
    public function index(GetConnectingTripsAction $action)
    {
        return $action->execute();
    }

    /**
     * Retrieve a single connecting trip
     */
    public function show(ConnectingTrip $connectingTrip, GetConnectingTripAction $action)
    {
        return $action->execute($connectingTrip->connecting_id);
    }

    /**
     * Search connecting trips by keyword
     */
    public function searchByKeyword(Request $request, GetConnectingTripByKeywordAction $action)
    {
        $keyword = $request->query('keyword', '');
        if (!$keyword) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Keyword is required',
            ], 400);
        }

        return $action->execute($keyword);
    }

    /**
     * Create a new connecting trip
     */
    public function store(Request $request, CreateConnectingTripAction $action)
    {
        return $action->execute($request->all());
    }

    /**
     * Update an existing connecting trip
     */
    public function update(Request $request, ConnectingTrip $connectingTrip, UpdateConnectingTripAction $action)
    {
        return $action->execute($connectingTrip, $request->all());
    }

    /**
     * Delete a connecting trip
     */
    public function destroy(ConnectingTrip $connectingTrip, DeleteConnectingTripAction $action)
    {
        return $action->execute($connectingTrip);
    }
}
