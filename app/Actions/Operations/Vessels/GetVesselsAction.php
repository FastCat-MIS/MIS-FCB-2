<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;

class GetVesselsAction extends Action
{
    public function execute()
    {
        try {
            $vessels = Vessel::with('accommodations.accommodation')->get();

            return $this->success([
                'vessels' => $vessels
            ], 'Vessels retrieved successfully.');
        } catch (\Throwable $e) {
            throw new \Exception('Failed to retrieve vessels: ' . $e->getMessage(), 500);
        }
    }
}
