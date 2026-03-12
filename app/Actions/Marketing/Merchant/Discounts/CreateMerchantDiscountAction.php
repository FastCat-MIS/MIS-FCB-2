<?php

namespace App\Actions\Marketing\Merchant\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\MerchantDiscount;
use Illuminate\Support\Facades\Validator;

class CreateMerchantDiscountAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $merchantDiscount = MerchantDiscount::create($validated);

          return $this->success([
            'data' => $merchantDiscount,
        ], 'Merchant Discount created successfully', 201);

    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'merchant_id' => 'required|integer|exists:merchants,merchant_id', 
            'route_id' => 'required|integer|exists:routes,route_id',
            'discount_name' => 'required|string|max:255',
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|string|max:100',
            'effective_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }
}