<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;

class UpdateInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account, array $data)
    {
        try {
            $validator = Validator::make($data, [
                'ia_name' => 'sometimes|required|string|max:255',
                'ia_image' => 'sometimes|required', // Blob or base64 string
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed.', 422, $validator->errors()->toArray());
            }

            $account->update($data);

            return $this->success([
                'institutional_account' => $account->fresh(),
            ], 'Institutional account updated successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to update institutional account.', 500, $e->getMessage());
        }
    }
}
