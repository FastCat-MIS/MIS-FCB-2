<?php

namespace App\Actions\Marketing\Merchant;

use App\Actions\Action;
use App\Models\Marketing\Merchant;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CreateMerchantAction extends Action
{
    public function execute(array $data)
    {
        $validated = $this->validate($data);

        $validated['merchant_code'] = $this->generateMerchantCode();
        
        $validated['password'] = Hash::make('Fastcat_01');
        
        if (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
            $validated['image'] = $data['logo']->store('merchant-logos', 'public');
        }

        $merchant = Merchant::create($validated);

        return $this->success([
            'data' => $merchant,
        ], 'Merchant created successfully', 201);
    }

    private function generateMerchantCode(): string
    {
        $now = Carbon::now();

        $count = Merchant::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->lockForUpdate()
            ->count();

        if ($count >= 100) {
            throw new Exception('Maximum of 100 merchants per month reached (00–99).');
        }

        $yearHex  = strtoupper(dechex($now->year));
        $monthHex = strtoupper(str_pad(dechex($now->month), STR_PAD_LEFT)); // 👈 fixed: was missing length, pad string, and pad type
        $decimal  = str_pad($count, 2, '0', STR_PAD_LEFT);

        return 'MT' . '-' . $yearHex . $monthHex . '-' . $decimal;
    }

    

    private function validate(array $data): array
    {
        return Validator::make($data, [
            'merchant_name'  => 'required|string|max:255',
            'image'          => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'email'          => 'required|string|email|max:255|unique:merchants,email',
            'contact_number' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'area'           => 'nullable|string|max:255',
            'payment_mode'   => 'required|string|max:255',
            'payment_type'   => 'required|string|max:255',
            'status'         => 'nullable|in:0,1,2,3',
            'effective_date' => 'nullable|date',
            'eoc_date'       => 'nullable|date',
        ])->validate();
    }
}