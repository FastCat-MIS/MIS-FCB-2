<?php

namespace App\Actions\Marketing\Merchant\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\MerchantDiscount;
use RuntimeException;

class GetMerchantDiscountsAction extends Action
{
   public function execute($merchantId)
    {
       try {
            $merchantDiscounts= MerchantDiscount::where('merchant_id', $merchantId)->with('route')->orderBy('route_id')->get();

            return $this->success([
                'merchantDiscounts' => $merchantDiscounts,
            ], 'Merchant discounts retrieved successfully');                        
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve merchant discounts.');     
        }    
    }
}