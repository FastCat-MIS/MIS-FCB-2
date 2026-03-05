<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\GetIADiscountsAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\GetIADiscountAction;
use App\Actions\Marketing\InstitutionalAccounts\Discounts\CreateIADiscountsAction;

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

    // public function store(Request $request, CreateIADiscountsAction $action)
    // {
    //     return $action->execute($request->all());
    // }

    // public function update(Request $request, Discount $discount, UpdateDiscountAction $updateDiscountAction)
    // {
    //     return $updateDiscountAction->execute($discount, $request->all());
    // }

    // public function destroy(Discount $discount, DeleteDiscountAction $deleteDiscountAction)
    // {
    //     return $deleteDiscountAction->execute($discount);
    // }
}
