<?php

namespace App\Actions\Marketing\AddOn;

use App\Actions\Action;
use App\Models\Marketing\AddOn;
use RuntimeException;

class GetAddOnsAction extends Action
{
   public function execute()
    {
       try {
            $addOns = AddOn::get();

            return $this->success([
                'addOns' => $addOns,
            ], 'AddOns retrieved successfully');                        
        } catch (\Exception $e) {
            throw new RuntimeException('Failed to retrieve addOns.');   
        }    
    }
}