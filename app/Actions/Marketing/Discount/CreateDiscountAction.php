<?php

namespace App\Actions\Marketing\Discount;

use App\Actions\Action;
use App\Models\Marketing\Discounts\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateDiscountAction extends Action
{
    public function execute(array $data)
    {
        try{

            $validated = $this->validate($data);
    
            $discount = Discount::create($validated);
    
            return $this->success([
                'discount' => $discount,
            ], 'Discount created successfully', 201);
        } catch (ValidationException $e) {

            return $this->error(
                'Validation failed',
                422,
                $e->errors()
            );
        }
    }
    private function validate(array $data): array
    {
        return Validator::make($data, [
            'discount_name' => 'required|string|max:225',
            'discount_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('discounts', 'discount_code')->whereNull('deleted_at')
            ], 
            'discount_value' => 'required|numeric|min:0',
            'value_type'   => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }

}
