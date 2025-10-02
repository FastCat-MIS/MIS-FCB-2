<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;

class GetInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account)
    {
        try {
            $account->load([]);

            return $this->success([
                'institutional_account' => $account,
            ], 'Institutional account retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve institutional account.', 500, $e->getMessage());
        }
    }
}
