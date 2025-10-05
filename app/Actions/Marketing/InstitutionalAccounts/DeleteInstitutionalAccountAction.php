<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\QueryException;

class DeleteInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account)
    {
        try {
            $account->delete();

            return $this->success([], 'Institutional account deleted successfully', 204);
        } catch (QueryException $e) {
            // DB-related errors (e.g., FK constraints) can be handled specifically
            throw new \RuntimeException('Failed to delete institutional account due to a database error.');
        } catch (\Exception $e) {
            // Generic fallback exception
            throw new \RuntimeException('Failed to delete institutional account.');
        }
    }
}
