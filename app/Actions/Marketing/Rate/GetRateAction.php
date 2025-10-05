<?php
// app/Actions/Marketing/Rate/GetRateAction.php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use RuntimeException;

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
            throw new RuntimeException('Failed to retrieve rate.');
        }
    }
}
