<?php

namespace App\Http\Controllers\Marketing;

use App\Actions\Marketing\Merchant\CreateMerchantAction;
use App\Actions\Marketing\Merchant\GetMerchantAction;
use App\Actions\Marketing\Merchant\GetMerchantsAction;
use App\Actions\Marketing\Merchant\ResetMerchantPasswordAction;
use App\Actions\Marketing\Merchant\UpdateMerchantAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MerchantController extends Controller
{
    public function index(GetMerchantsAction $action)
    {
        return $action->execute();
    }

    public function show($merchantId, GetMerchantAction $action)
    {
        return $action->execute($merchantId);
    }

    public function store(Request $request, CreateMerchantAction $action)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = array_merge($request->except('logo'), [
            'logo' => $request->file('logo'), 
        ]);

        return $action->execute($data);
    }

    public function update(Request $request, $merchantId, UpdateMerchantAction $action)
    {

        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = array_merge($request->except('logo'), [
            'logo' => $request->file('logo'), 
        ]);

        return $action->execute($merchantId, $data);
    }

    // public function destroy($merchantId, DeleteMerchantAction $action)
    // {
    //     return $action->execute($merchantId);
    // }

    public function reset($merchantId, ResetMerchantPasswordAction $action)
    {
        return $action->execute($merchantId);
    }
}
