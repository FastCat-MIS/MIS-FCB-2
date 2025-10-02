<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;

class CreateInstitutionalAccountAction extends Action
{
    public function execute(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'ia_name' => 'required|string|max:255',
                'ia_image' => 'required', // Blob or base64 string
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $account = InstitutionalAccount::create($data);

            return $this->success([
                'institutional_account' => $account,
            ], 'Institutional account created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create institutional account.', 500, $e->getMessage());
        }
    }
}
