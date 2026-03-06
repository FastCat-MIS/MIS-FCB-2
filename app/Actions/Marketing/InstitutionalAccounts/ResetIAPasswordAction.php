<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class ResetIAPasswordAction extends Action
{
    public function execute(int $iaId)
    {
        try {
            $ia = InstitutionalAccount::findOrFail($iaId);

            $defaultPassword = 'Fastcat_01';

            $ia->password = Hash::make($defaultPassword);
            $ia->save();

            return $this->success([
                
            ], 'Institutional account password reset successfully');

        } catch (QueryException $e) {
            throw $e;
        }
    }
}