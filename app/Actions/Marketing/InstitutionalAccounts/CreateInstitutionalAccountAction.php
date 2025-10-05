<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class CreateInstitutionalAccountAction extends Action
{
    public function execute(array $data)
    {
        // Validate input
        $validator = Validator::make($data, [
            'ia_name' => 'required|string|max:255',
            'ia_image' => 'required', // Blob or base64 string
        ]);

        if ($validator->fails()) {
            // Will be caught by global exception handler
            throw new ValidationException($validator);
        }

        try {
            $account = InstitutionalAccount::create($data);

            return $this->success([
                'institutional_account' => $account,
            ], 'Institutional account created successfully', 201);
        } catch (QueryException $e) {
            // Will be caught by global fallback if not explicitly handled
            throw new \RuntimeException('Failed to create institutional account.');
        }
    }
}
