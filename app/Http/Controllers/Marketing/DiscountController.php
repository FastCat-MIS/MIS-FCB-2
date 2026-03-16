<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Marketing\Discount\GetDiscountsAction;
use App\Actions\Marketing\Discount\GetDiscountAction;
use App\Actions\Marketing\Discount\CreateDiscountAction;
use App\Actions\Marketing\Discount\UpdateDiscountAction;
use App\Actions\Marketing\Discount\DeleteDiscountAction;

class DiscountController extends Controller
{
    public function index(GetDiscountsAction $action)
    {
        return $action->execute();
    }

    public function show($discountId, GetDiscountAction $action)
    {
        return $action->execute($discountId);
    }

    public function store(Request $request, CreateDiscountAction $action)
    {
        return $action->execute($request->all());
    }

    public function update($discountId, Request $request, UpdateDiscountAction $action)
    {
        return $action->execute($discountId, $request->all());
    }

    public function destroy($discountId, DeleteDiscountAction $action)
    {
        return $action->execute($discountId);
    }
}
