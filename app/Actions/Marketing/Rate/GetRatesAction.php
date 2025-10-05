<?php
// app/Actions/Marketing/Rate/GetRatesAction.php

namespace App\Actions\Marketing\Rate;

use App\Actions\Action;
use App\Models\Marketing\Rate;
use RuntimeException;

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
            throw new RuntimeException('Failed to retrieve rates.');
        }
    }
}
