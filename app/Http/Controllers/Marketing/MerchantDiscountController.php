<?php

namespace App\Http\Controllers\Marketing;

use App\Actions\Marketing\Merchant\Discounts\CreateMerchantDiscountAction;
use App\Actions\Marketing\Merchant\Discounts\DeleteMerchantDiscountAction;
use App\Actions\Marketing\Merchant\Discounts\GetMerchantDiscountsAction;
use App\Actions\Marketing\Merchant\Discounts\UpdateMerchantDiscountAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MerchantDiscountController extends Controller
{
    public function index(int $merchantId,GetMerchantDiscountsAction $action)
    {
        return $action->execute($merchantId);
    }

    // public function show($merchantDiscountId, GetMerchantDiscountAction $action)
    // {
    //     return $action->execute($merchantDiscountId);
    // }

    public function store(Request $request, CreateMerchantDiscountAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, $merchantDiscountId, UpdateMerchantDiscountAction $action)
    {
        return $action->execute($merchantDiscountId, $request->all());
    }

    public function destroy($merchantDiscountId, DeleteMerchantDiscountAction $action)
    {
        return $action->execute($merchantDiscountId);
    }

}
