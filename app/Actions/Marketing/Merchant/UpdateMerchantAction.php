<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateMerchantAction extends Action
{
    public function execute(int $merchantId, array $data)
    {
        $merchant = Merchant::findOrFail($merchantId);
        $validated = $this->validate($data, $merchantId); 

        if (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
            $validated['image'] = $data['logo']->store('ia-logos', 'public');
        }


        $merchant->update($validated);

        return $this->success([
            'data' => $merchant,
        ], 'Merchant updated successfully', 200);
    }

    private function validate(array $data, int $merchantId): array
    {
        return Validator::make($data, [
            'merchant_name' => 'sometimes|required|string|max:255', 
            'image' => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('merchants', 'email')->ignore($merchantId, 'merchant_id'),
            ],
            'contact_number' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'payment_mode' => 'sometimes|required|string|max:255',
            'payment_type' => 'sometimes|required|string|max:255',
            'status'         => 'nullable|in:0,1,2,3',
            'effective_date' => 'nullable|date',
            'eoc_date' => 'nullable|date',
        ])->validate();
    }
}