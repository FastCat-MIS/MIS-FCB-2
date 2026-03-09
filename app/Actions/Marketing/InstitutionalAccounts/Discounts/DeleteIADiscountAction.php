<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use RuntimeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteIADiscountAction extends Action
{

    public function execute(int $iaDiscountId)
    {
      try {
          $iaDiscount = IADiscount::findOrFail($iaDiscountId); 

          $iaDiscount->delete();

          return $this->success([], 'IA Discount deleted successfully', 204);        
      } catch (ModelNotFoundException $e) {
          throw new RuntimeException("IA Discount with ID {$iaDiscountId} not found.");
      } catch (\Exception $e) {
          throw new RuntimeException('Failed to delete IA Discount.');
      }
    }
}