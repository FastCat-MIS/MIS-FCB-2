<?php

namespace App\Actions\Marketing\Merchant\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\MerchantDiscount;
use Illuminate\Support\Facades\Validator;

class UpdateMerchantDiscountAction extends Action
{
    public function execute(int $merchantDiscountId, array $data)
    {
      $merchantDiscount = MerchantDiscount::findOrFail($merchantDiscountId);

      $validated = $this->validate($data);

      $merchantDiscount->update($validated);

      return $this->success([
          'data' => $merchantDiscount,
      ], 'Merchant discount updated successfully', 200);  
    }
    private function validate(array $data): array
    {
        return Validator::make($data, [
            'route_id'       => 'required|integer|exists:routes,route_id',
            'discount_name'  => 'required|string|max:255',
            'discount_value' => 'required|numeric|min:0',
            'value_type'     => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'status'         => 'nullable|in:0,1,2,3',
        ])->validate();
    }
}