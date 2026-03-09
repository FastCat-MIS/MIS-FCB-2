<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Marketing\InstitutionalAccounts\GetInstitutionalAccountsAction;
use App\Actions\Marketing\InstitutionalAccounts\GetInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\CreateInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\UpdateInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\DeleteInstitutionalAccountAction;
use App\Actions\Marketing\InstitutionalAccounts\ResetIAPasswordAction;


class InstitutionalAccountController extends Controller
{
    public function index(GetInstitutionalAccountsAction $action)
    {
        return $action->execute();
    }

    public function show($iaId, GetInstitutionalAccountAction $action)
    {
        return $action->execute($iaId);
    }

    public function store(Request $request, CreateInstitutionalAccountAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, $iaId, UpdateInstitutionalAccountAction $action)
    {
        return $action->execute($iaId, $request->all());
    }

    public function destroy($iaId, DeleteInstitutionalAccountAction $action)
    {
        return $action->execute($iaId);
    }

    public function reset($iaId, ResetIAPasswordAction $action)
    {
        return $action->execute($iaId);
    }
}
