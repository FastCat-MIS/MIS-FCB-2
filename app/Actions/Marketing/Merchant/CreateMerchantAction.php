<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CreateMerchantAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);
        $validated['password'] = Hash::make('Fastcat_01');
        $merchant = Merchant::create($validated);

        return $this->success([
            'data' => $merchant,
        ], 'Merchant created successfully', 201);
    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'merchant_name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants,email',
            'contact_number' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'payment_mode' => 'required|string|max:255',
            'payment_type' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'effective_date' => 'nullable|date',
            'eoc_date' => 'nullable|date',
        ])->validate();
    }
}