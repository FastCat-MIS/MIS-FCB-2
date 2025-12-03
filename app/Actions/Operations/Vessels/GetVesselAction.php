<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;

class GetVesselAction extends Action
{
    public function execute(Vessel $vessel)
    {
        try {
            $vessel->load('accommodations.accommodation');

            return $this->success([
                'vessel' => $vessel
            ], 'Vessel retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve vessel: ' . $e->getMessage(), 500);
        }
    }
}
