<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Illuminate\Database\QueryException;
use Exception;
use RuntimeException;

class GetMerchantsAction extends Action
{
    public function execute()
    {
        try {
            $merchants = Merchant::all();

            return $this->success([
                'merchants' => $merchants,
            ], 'Merchants retrieved successfully');
        } catch (QueryException $e) {
            throw new RuntimeException('Database error while retrieving merchants.');
        } catch (Exception $e) {
            throw new RuntimeException('Failed to retrieve merchants.');
        }
    }
}
