<?php

namespace App\Actions\Marketing\AddOn;

use App\Actions\Action;
use App\Models\Marketing\AddOn;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;
class UpdateAddOnAction extends Action
{
    public function execute(AddOn $addOn, array $data)
        {
             $validator = Validator::make($data, [
                'add_on_name' => 'required|string|max:255',
                'value' => 'required|numeric|min:0',
                'value_type' => 'required|in:0,1',
                'operator' => 'required|in:0,1'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $addOn->update($data);

            return $this->success([
                'addOn' => $addOn->fresh(),
            ], 'AddOn updated successfully');   
        }
}