<?php

namespace App\Actions\Operations\VesselLayout;

use App\Models\Operations\VesselAccommodation;
use App\Models\Operations\Vessel;

class DeleteVesselLayoutAction
{
    public function execute(Vessel $vessel)
    {
        VesselAccommodation::where('vessel_id', $vessel->id)->delete();

        return ['message' => 'Vessel layout deleted'];
    }
}
