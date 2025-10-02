<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;

class GetInstitutionalAccountsAction extends Action
{
    public function execute(array $data = [])
    {
        try {
            $accounts = InstitutionalAccount::all();

            return $this->success([
                'institutional_accounts' => $accounts,
            ], 'Institutional accounts retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve institutional accounts.', 500, $e->getMessage());
        }
    }
}
