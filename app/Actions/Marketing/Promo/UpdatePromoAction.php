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
        try{

            $promo = Promo::findOrFail($promoId);

            $validated = $this->validate($data, $promoId);

            $promo->update($validated);

            return $this->success([
                'promo' => $promo->fresh(),
            ], 'Promo updated successfully');
        } catch (ValidationException $e) {
            return $this->error(
                'Validation failed',
                422,
                $e->errors()
            );
        }
    }

    private function validate(array $data, int $promoId): array
    {
        return Validator::make($data, [
            'promo_name' => 'nullable|string|max:100',
            'promo_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('promos', 'promo_code')->ignore($promoId, 'promo_id')->whereNull('deleted_at'),
            ],            
            'promo_value' => 'nullable|numeric|min:0',
            'value_type' => 'nullable|in:0,1',
            'effective_date' => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:effective_date',
            'status'         => 'nullable|in:0,1,2,3',
        ])->validate();
    }
}
