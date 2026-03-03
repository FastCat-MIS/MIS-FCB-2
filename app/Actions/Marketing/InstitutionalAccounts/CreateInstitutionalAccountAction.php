<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CreateInstitutionalAccountAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);
        $validated['password'] = Hash::make($validated['password']);
        $institutionalAccount = InstitutionalAccount::create($validated);

        return $this->success([
            'data' => $institutionalAccount,
        ], 'Institutional account created successfully', 201);
    }

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'ia_name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:institutional_accounts,email',
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'mode_of_payment' => 'required|string|max:255',
            'type_of_payment' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'effective_date' => 'nullable|date',
            'eoc_date' => 'nullable|date',
        ])->validate();
    }
}