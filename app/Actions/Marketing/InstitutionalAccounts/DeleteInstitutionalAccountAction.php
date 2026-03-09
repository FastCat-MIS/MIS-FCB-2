<?php

namespace App\Actions\Marketing\InstitutionalAccounts;

use App\Actions\Action;
use App\Models\Marketing\InstitutionalAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class DeleteInstitutionalAccountAction extends Action
{
    public function execute(int $iaId)
    {
        try {
            $institutionalAccount = InstitutionalAccount::findOrFail($iaId); 

            $institutionalAccount->delete();

            return $this->success([], 'Institutional account deleted successfully', 204);        
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException("Institutional account with ID {$iaId} not found.");
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to delete Institutional account.');
        }
    }
}
