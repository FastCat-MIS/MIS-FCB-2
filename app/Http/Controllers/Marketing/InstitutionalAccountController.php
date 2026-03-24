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
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = array_merge($request->except('logo'), [
            'logo' => $request->file('logo'), 
        ]);

        return $action->execute($data);
    }

    public function update(Request $request, $iaId, UpdateInstitutionalAccountAction $action)
    {

        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = array_merge($request->except('logo'), [
            'logo' => $request->file('logo'), 
        ]);

        return $action->execute($iaId, $data);
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
