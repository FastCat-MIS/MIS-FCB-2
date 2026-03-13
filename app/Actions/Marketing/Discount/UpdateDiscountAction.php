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
        try{
        
            $discount = Discount::findOrFail($discountId);
      
            $validated = $this->validate($data, $discountId);
      
            $discount->update($validated);
      
              return $this->success([
                  'discount' => $discount->fresh(),
              ], 'Discount updated successfully');
        } catch (ValidationException $e) {

            return $this->error(
                'Validation failed',
                422,
                $e->errors()
            );
        }
    }

    private function validate(array $data, int $discountId): array
    {
        return Validator::make($data, [
            'discount_name' => 'nullable|string|max:100',
            'discount_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('discounts', 'discount_code')
                    ->ignore($discountId, 'discount_id')
                    ->whereNull('deleted_at'),
            ],         
            'discount_value' => 'nullable|numeric|min:0',
            'value_type' => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }
}
