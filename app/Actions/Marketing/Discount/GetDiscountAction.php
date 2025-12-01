<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discount;
use RuntimeException;

class GetDiscountAction extends Action
{
    public function execute(Discount $discount)
    {
        try {
            return $this->success([
                'discount' => $discount,
            ], 'Discount retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve discount.');
        }
    }
}
