<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateDiscountAction extends Action
{
    public function execute(int $discountId, array $data)
    {
      $discount = Discount::findOrFail($discountId);

      $validated = $this->validate($data, $discountId);

      $discount->update($validated);

        return $this->success([
            'discount' => $discount->fresh(),
        ], 'Discount updated successfully');
    }

    private function validate(array $data, int $discountId): array
    {
        return Validator::make($data, [
            'discount_name' => 'nullable|string|max:100',
            'discount_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('discounts', 'discount_code')->ignore($discountId, 'discount_id')
            ],            
            'discount_value' => 'nullable|numeric|min:0|max:100',
            'discount_type'   => 'nullable|string|max:255',
            'effective_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }
}
