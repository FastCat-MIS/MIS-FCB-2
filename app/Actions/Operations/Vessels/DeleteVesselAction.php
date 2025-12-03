<?php

namespace App\Actions\Operations\Vessels;

use App\Actions\Action;
use App\Models\Operations\Vessel;

class DeleteVesselAction extends Action
{
    public function execute(Vessel $vessel)
    {
        try {
            $vessel->delete();

            return $this->success([], 'Vessel deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to delete vessel: ' . $e->getMessage(), 500);
        }
    }
}
