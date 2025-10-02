<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Marketing\InstitutionalAccounts\GetInstitutionalAccountsAction;
use App\Actions\Marketing\InstitutionalAccounts\GetInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\CreateInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\UpdateInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\DeleteInstitutionalAccountAction;
use App\Models\Marketing\InstitutionalAccount;

class InstitutionalAccountController extends Controller
{
    public function index(GetInstitutionalAccountsAction $action)
    {
        return $action->execute();
    }

    public function show(InstitutionalAccount $institutionalAccount, GetInstitutionalAccountAction $action)
    {
        return $action->execute($institutionalAccount);
    }

    public function store(Request $request, CreateInstitutionalAccountAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, InstitutionalAccount $institutionalAccount, UpdateInstitutionalAccountAction $action)
    {
        return $action->execute($institutionalAccount, $request->all());
    }

    public function destroy(InstitutionalAccount $institutionalAccount, DeleteInstitutionalAccountAction $action)
    {
        return $action->execute($institutionalAccount);
    }
}
