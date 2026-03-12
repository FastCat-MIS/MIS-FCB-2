<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use RuntimeException;

class GetDiscountAction extends Action
{
    public function execute(int $discountId)
    {
        try {
             $discount = Discount::findOrFail($discountId);
            return $this->success([
                'discount' => $discount,
            ], 'Discount retrieved successfully');
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve discount.');
        }
    }
}
