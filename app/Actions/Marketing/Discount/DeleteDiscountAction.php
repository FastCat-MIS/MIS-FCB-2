<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use RuntimeException;

class DeleteDiscountAction extends Action
{
    public function execute(int $discountId)
    {
        try {

            $discount = Discount::findOrFail($discountId);
            
            $discount->delete();
            return $this->success([], 'Discount deleted successfully', 204);
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete discount.');
        }
    }
}
