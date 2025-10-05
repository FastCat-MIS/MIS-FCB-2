<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetInstitutionalAccountAction extends Action
{
    public function execute(InstitutionalAccount $account)
    {
        try {
            $account->load([]); // Add relationships if needed

            return $this->success([
                'institutional_account' => $account,
            ], 'Institutional account retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Institutional account not found.');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve institutional account.');
        }
    }
}
