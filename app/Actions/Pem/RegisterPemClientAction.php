<?php

namespace App\Actions\Pem;

use App\Actions\Action;
use App\Models\PemClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class RegisterPemClientAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'client_name' => 'required|string|max:255',
            'pem_public_key' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string|in:payment.read,payment.write,*',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        // Generate fingerprint from PEM key
        $pemFingerprint = $this->generatePemFingerprint($validated['pem_public_key']);

        // Check if PEM key already registered
        $existingClient = PemClient::where('pem_fingerprint', $pemFingerprint)->first();
        
        if ($existingClient) {
            return $this->error('PEM key already registered', 409);
        }

        // Create new PEM client
        $pemClient = PemClient::create([
            'client_name' => $validated['client_name'],
            'pem_public_key' => Crypt::encrypt($validated['pem_public_key']),
            'pem_fingerprint' => $pemFingerprint,
            'permissions' => $validated['permissions'],
        ]);

        return $this->success([
            'pem_client' => $pemClient,
            'fingerprint' => $pemFingerprint,
        ], 'PEM client registered successfully', 201);
    }

    private function generatePemFingerprint(string $pemPublicKey): string
    {
        // Clean PEM key (remove headers, footers, whitespace)
        $cleanPem = preg_replace('/-----.*-----/', '', $pemPublicKey);
        $cleanPem = preg_replace('/\s+/', '', $cleanPem);
        
        // Generate SHA256 fingerprint
        return hash('sha256', base64_decode($cleanPem));
    }
}