<?php
namespace App\Http\Controllers\Operations;

use App\Actions\Operations\Vehicles\CreateVehicleAction;
use App\Actions\Operations\Vehicles\GetVehiclesAction;
use App\Actions\Operations\Vehicles\GetVehicleAction;
use App\Actions\Operations\Vehicles\UpdateVehicleAction;
use App\Actions\Operations\Vehicles\DeleteVehicleAction;
use App\Http\Controllers\Controller;
use App\Models\Operations\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
      /**
     * Display a listing of vehicle.
     */
    public function index(GetVehiclesAction $getVehiclesAction)
    {
        return $getVehiclesAction->execute();
    }

    /**
     * Display the specified vehicle.
     */

    public function show(int $vehicleId, GetVehicleAction $getVehicleAction)
    {
        return $getVehicleAction->execute($vehicleId);
    }

    // /**
    //  * Store a newly created vehicle.
    //  */

    public function store(Request $request, CreateVehicleAction $createVehicleAction)
    {
        return $createVehicleAction->execute($request->all());
    }

    // /**
    //  * Update the specified vehicle.
    //  */

    public function update(Request $request, int $vehicleId, UpdateVehicleAction $updateVehicleAction)
    {
        return $updateVehicleAction->execute($vehicleId, $request->all());
    }

    // /**
    //  * Remove the specified vehicle.
    //  */


    public function destroy($vehicleId, DeleteVehicleAction $deleteVehicleAction)
    {
        return $deleteVehicleAction->execute($vehicleId);
    }

}