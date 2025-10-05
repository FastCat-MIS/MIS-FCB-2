<?php
// app/Actions/Marketing/Rate/DeleteRateAction.php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use RuntimeException;

class DeleteRateAction extends Action
{
    public function execute(Rate $rate)
    {
        // ❗ Prevent deleting active rates
        if ($rate->status === 'active') {
            throw new RuntimeException('Cannot delete active rate. Deactivate it first.', 409);
        }

        try {
            $rate->delete();

            return $this->success([], 'Rate deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete rate.');
        }
    }
}
