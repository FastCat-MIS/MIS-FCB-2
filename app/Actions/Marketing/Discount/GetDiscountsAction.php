<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use RuntimeException;

class GetDiscountsAction extends Action
{
    public function execute()
    {
        try {
            $discounts = Discount::all();

            return $this->success([
                'discounts' => $discounts,
            ], 'Discounts retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve discounts.');
        }
    }
}
