<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetMerchantAction extends Action
{
    public function execute(int $merchantId)
    {
        try {
            $merchant = Merchant::findOrFail($merchantId);

            return $this->success([
                'merchant' => $merchant,
            ], 'Merchant retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Merchant not found.');
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve merchant.');
        }
    }
}
