<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateDiscountAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'discount_type' => 'required|string|max:100',
            'discount_code' => 'required|string|max:50|unique:discounts,discount_code',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $discount = Discount::create($data);

        return $this->success([
            'discount' => $discount,
        ], 'Discount created successfully', 201);
    }
}
