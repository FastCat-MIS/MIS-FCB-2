<?php

namespace App\Actions\Marketing\InstitutionalAccounts\Discounts;

use App\Actions\Action;
use App\Models\Marketing\Discounts\IADiscount;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateIADiscountAction extends Action
{
    public function execute(int $iaDiscountId, array $data)
  {
    $iaDiscount = IADiscount::findOrFail($iaDiscountId);

    $validated = $this->validate($data);

    $iaDiscount->update($validated);

    return $this->success([
        'data' => $iaDiscount,
    ], 'Institutional account discount updated successfully', 200);
  }
    private function validate(array $data): array
  {
      return Validator::make($data, [
          'route_id'       => 'required|integer|exists:routes,route_id',
          'discount_name'   => 'required|string|max:255',
          'discount_value'   => 'required|numeric|min:0',
          'discount_type'   => 'required|string|max:255',
          'effective_date' => 'nullable|date',
          'status'         => 'nullable|in:active,inactive',
      ])->validate();
  }
}