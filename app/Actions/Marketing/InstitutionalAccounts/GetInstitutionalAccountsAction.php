<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\QueryException;

class GetInstitutionalAccountsAction extends Action
{
    public function execute()
    {
        try {
            $accounts = InstitutionalAccount::all();

            return $this->success([
                'institutional_accounts' => $accounts,
            ], 'Institutional accounts retrieved successfully');
        } catch (QueryException $e) {
            throw new \RuntimeException('Database error while retrieving institutional accounts.');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve institutional accounts.');
        }
    }
}
