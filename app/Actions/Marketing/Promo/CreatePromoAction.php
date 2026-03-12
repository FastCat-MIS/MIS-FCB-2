<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePromoAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $promo = promo::create($validated);

        return $this->success([
            'promo' => $promo,
        ], 'promo created successfully', 201);
    }
    private function validate(array $data): array
    {
        return Validator::make($data, [
            'promo_name' => 'required|string|max:225',
            'promo_code' => 'required|string|max:100|unique:promos,promo_code',
            'promo_value' => 'required|numeric|min:0',
            'promo_type'   => 'required|string|max:100',
            'effective_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }

}
