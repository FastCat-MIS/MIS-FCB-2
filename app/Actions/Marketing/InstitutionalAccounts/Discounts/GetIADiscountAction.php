<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use RuntimeException;

class GetIADiscountAction extends Action
{
    public function execute(int $iaDiscountId) 
    {
        try {
            $iaDiscount = IADiscount::findOrFail($iaDiscountId); 

            return $this->success([
                'iaDiscount' => $iaDiscount,
            ], 'IADiscount retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new RuntimeException("IA Discount with ID {$iaDiscountId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve IA Discount.');
        }
    }
}