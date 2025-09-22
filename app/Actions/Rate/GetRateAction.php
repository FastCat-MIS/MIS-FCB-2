<?php
// app/Actions/Rate/GetRateAction.php

namespace App\Actions\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;

class GetRateAction extends Action
{
    public function execute(Rate $rate, array $data = [])
    {
        try {
            $rate->load(['route']);

            return $this->success([
                'rate' => $rate,
            ], 'Rate retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve rate.', 500, $e->getMessage());
        }
    }
}
