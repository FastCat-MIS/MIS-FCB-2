<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetInstitutionalAccountAction extends Action
{
    public function execute(int $iaId)
    {
        try {
            $institutionalAccount = InstitutionalAccount::findOrFail($iaId);

            return $this->success([
                'institutional_account' => $institutionalAccount,
            ], 'Institutional account retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Institutional account not found.');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve institutional account.');
        }
    }
}
