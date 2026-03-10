<?php

namespace App\Actions\Marketing\Merchant\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\MerchantDiscount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class DeleteMerchantDiscountAction extends Action
{

    public function execute(int $merchantDiscountId)
    {
      try {
          $merchantDiscount = MerchantDiscount::findOrFail($merchantDiscountId); 

          $merchantDiscount->delete();

          return $this->success([], 'Merchant Discount deleted successfully', 204);        
      } catch (ModelNotFoundException $e) {
          throw new RuntimeException("Merchant Discount with ID {$merchantDiscountId} not found.");
      } catch (\Exception $e) {
          throw new RuntimeException('Failed to delete Merchant Discount.');
      }
    }
}