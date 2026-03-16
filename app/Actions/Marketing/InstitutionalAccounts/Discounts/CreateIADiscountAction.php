<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use Illuminate\Support\Facades\Validator;

class CreateIADiscountAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $iaDiscount = IADiscount::create($validated);

          return $this->success([
            'data' => $iaDiscount,
        ], 'IA Discount created successfully', 201);

    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'ia_id' => 'required|integer|exists:institutional_accounts,ia_id',
            'route_id'       => 'required|integer|exists:routes,route_id',
            'discount_name'   => 'required|string|max:255',
            'discount_value'   => 'required|numeric|min:0',
            'value_type' => 'required|in:0,1',
            'effective_date' => 'nullable|date',
            'status'         => 'nullable|in:active,inactive',
        ])->validate();
    }
}