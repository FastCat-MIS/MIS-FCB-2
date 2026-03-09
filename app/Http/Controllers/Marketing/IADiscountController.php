<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\GetIADiscountsAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\GetIADiscountAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\CreateIADiscountAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\DeleteIADiscountAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\UpdateIADiscountAction;



class IADiscountController extends Controller
{
    public function index($iaId, GetIADiscountsAction $action)
    {
        return $action->execute($iaId);
    }

    // public function show($iaDiscountId, GetIADiscountAction $action)
    // {
    //     return $action->execute($iaDiscountId);
    // }

    public function store(Request $request, CreateIADiscountAction $action)
    {
        return $action->execute($request->all());
    }

    public function update($iaDiscountId, Request $request,  UpdateIADiscountAction $action )
    {
        return $action->execute($iaDiscountId,  $request->all());
    }

    public function destroy($iaDiscountId, DeleteIADiscountAction $action)
    {
        return $action->execute($iaDiscountId);
    }
}
