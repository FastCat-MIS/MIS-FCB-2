<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;

class DeleteInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account)
    {
        try {
            $account->delete();

            return $this->success([], 'Institutional account deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete institutional account.', 500, $e->getMessage());
        }
    }
}
