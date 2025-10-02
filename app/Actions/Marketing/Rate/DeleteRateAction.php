<?php
// app/Actions/Marketing/Rate/DeleteRateAction.php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;

class DeleteRateAction extends Action
{
    public function execute(Rate $rate)
    {
        try {
            // Check if rate is active
            if ($rate->status === 'active') {
                return $this->error('Cannot delete active rate. Deactivate it first.', 409);
            }

            $rate->delete();

            return $this->success([], 'Rate deleted successfully');

        } catch (\Exception $e) {
            return $this->error('Failed to delete rate.', 500, $e->getMessage());
        }
    }
}
