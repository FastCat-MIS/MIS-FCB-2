<?php

namespace App\Actions\Marketing\Promo;

use App\Actions\Action;
use App\Models\Marketing\Promo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdatePromoAction extends Action
{
    public function execute(int $promoId, array $data)
    {
      $promo = Promo::findOrFail($promoId);

      $validated = $this->validate($data, $promoId);

      $promo->update($validated);

        return $this->success([
            'promo' => $promo->fresh(),
        ], 'Promo updated successfully');
    }

    private function validate(array $data, int $promoId): array
    {
        return Validator::make($data, [
            'promo_name' => 'nullable|string|max:100',
            'promo_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('promos', 'promo_code')->ignore($promoId, 'promo_id')
            ],            
            'promo_value' => 'nullable|numeric|min:0|max:100',
            'promo_type'   => 'nullable|string|max:255',
            'effective_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:effective_date',
            'status' => 'nullable|in:active,inactive',
        ])->validate();
    }
}
