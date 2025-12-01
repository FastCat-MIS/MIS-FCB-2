<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateDiscountAction extends Action
{
    public function execute(Discount $discount, array $data)
    {
        $validator = Validator::make($data, [
            'discount_type' => 'sometimes|required|string|max:100',
            'discount_code' => 'sometimes|required|string|max:50|unique:discounts,discount_code,' . $discount->discount_id . ',discount_id',
            'discount_percentage' => 'sometimes|required|numeric|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $discount->update($data);

        return $this->success([
            'discount' => $discount->fresh(),
        ], 'Discount updated successfully');
    }
}
