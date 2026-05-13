<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pem_clients', function (Blueprint $table) {
            $table->id('pem_client_id');
            $table->string('client_name', 255);
            $table->text('pem_public_key'); // Store the PEM public key
            $table->string('pem_fingerprint', 64)->unique(); // SHA256 fingerprint for quick lookup
            $table->json('permissions')->nullable(); // JSON array of allowed endpoints
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['pem_fingerprint', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pem_clients');
    }
};