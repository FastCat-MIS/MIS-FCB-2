<?php

namespace App\Actions\Operations\Vdar;

use App\Actions\Action;
use App\Models\Operations\Vdar;

class DeleteVdarAction extends Action
{
    public function execute(Vdar $vdar)
    {
        try {
            $vdar->delete();

            return $this->success([], 'VDAR deleted successfully.', 204);
        } catch (\Throwable $e) {
            throw new \Exception('Failed to delete VDAR: ' . $e->getMessage(), 500);
        }
    }
}
