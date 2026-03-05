<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateInstitutionalAccountAction extends Action
{
    public function execute(int $iaId, array $data)
    {
        $institutionalAccount = InstitutionalAccount::findOrFail($iaId);
        $validated = $this->validate($data, $iaId);
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $institutionalAccount->update($validated);

        return $this->success([
            'data' => $institutionalAccount,
        ], 'Institutional account updated successfully', 200);
    }

    private function validate(array $data, int $iaId): array
    {
        return Validator::make($data, [
            'ia_name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('institutional_accounts', 'email')->ignore($iaId, 'ia_id'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'contact_number' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'payment_mode' => 'sometimes|required|string|max:255',
            'payment_type' => 'sometimes|required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'effective_date' => 'nullable|date',
            'eoc_date' => 'nullable|date',
        ])->validate();
    }
}