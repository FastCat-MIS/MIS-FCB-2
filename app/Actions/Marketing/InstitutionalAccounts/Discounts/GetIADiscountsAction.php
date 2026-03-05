<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use RuntimeException;

class GetIADiscountsAction extends Action
{
   public function execute($iaId)
    {
       try {
            $iaDiscounts= IADiscount::where('ia_id', $iaId)->with('route')->get();

            return $this->success([
                'iaDiscounts' => $iaDiscounts,
            ], 'IA discounts retrieved successfully');                        
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve IA discounts.');   
        }    
    }
}