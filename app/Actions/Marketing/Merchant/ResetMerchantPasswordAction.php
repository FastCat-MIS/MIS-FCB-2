<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class ResetMerchantPasswordAction extends Action
{
    public function execute(int $merchantId)
    {
        try {
            $merchant = Merchant::findOrFail($merchantId);

            $defaultPassword = 'Fastcat_01';

            $merchant->password = Hash::make($defaultPassword);
            $merchant->save();

            return $this->success([
                'data' => $merchant,
            ], 'Merchant password reset successfully'); 

        } catch (QueryException $e) {
            throw $e;
        }
    }
}