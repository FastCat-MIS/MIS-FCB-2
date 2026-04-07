<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Actions\Accounts\User\GetVesselMastersAction;

class UserController extends Controller
{
    public function vesselMasters(GetVesselMastersAction $action)
    {
        return $action->execute();
    }
}
