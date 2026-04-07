<?php

namespace App\Actions\Accounts\User;

use App\Actions\Action;
use App\Models\Accounts\User;

class GetVesselMastersAction extends Action
{
    public function execute()
    {
        $vesselMasters = User::role('Vessel Master')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'email', 'status')
            ->get();

        return $this->success([
            'vessel_masters' => $vesselMasters,
        ], 'Vessel masters retrieved successfully.');
    }
}
