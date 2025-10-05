<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class UpdateInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account, array $data)
    {
        // Manual validation
        $validator = Validator::make($data, [
            'ia_name' => 'sometimes|required|string|max:255',
            'ia_image' => 'sometimes|required', // Blob or base64 string
        ]);

        if ($validator->fails()) {
            // Let global handler catch this (422 response)
            throw new ValidationException($validator);
        }

        try {
            $account->update($data);

            return $this->success([
                'institutional_account' => $account->fresh(),
            ], 'Institutional account updated successfully');
        } catch (QueryException $e) {
            throw new \RuntimeException('Database error while updating institutional account.');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to update institutional account.');
        }
    }
}
