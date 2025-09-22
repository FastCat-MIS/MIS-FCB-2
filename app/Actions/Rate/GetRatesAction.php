<?php
// app/Actions/Rate/GetRatesAction.php

namespace App\Actions\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;

class GetRatesAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $rates = Rate::with(['route'])->get();

            return $this->success([
                'rates' => $rates,
            ], 'Rates retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve rates.', 500, $e->getMessage());
        }
    }
}
