<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Marketing\Discounts\Discount;
use Illuminate\Http\Request;
use App\Actions\Marketing\Discount\GetDiscountsAction;
use App\Actions\Marketing\Discount\GetDiscountAction;
use App\Actions\Marketing\Discount\CreateDiscountAction;
use App\Actions\Marketing\Discount\UpdateDiscountAction;
use App\Actions\Marketing\Discount\DeleteDiscountAction;

class DiscountController extends Controller
{
    public function index(GetDiscountsAction $getDiscountsAction)
    {
        return $getDiscountsAction->execute();
    }

    public function show(Discount $discount, GetDiscountAction $getDiscountAction)
    {
        return $getDiscountAction->execute($discount);
    }

    public function store(Request $request, CreateDiscountAction $createDiscountAction)
    {
        return $createDiscountAction->execute($request->all());
    }

    public function update(Request $request, Discount $discount, UpdateDiscountAction $updateDiscountAction)
    {
        return $updateDiscountAction->execute($discount, $request->all());
    }

    public function destroy(Discount $discount, DeleteDiscountAction $deleteDiscountAction)
    {
        return $deleteDiscountAction->execute($discount);
    }
}
