<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutional_accounts', function (Blueprint $table) {
            $table->id('ia_id');
            $table->string('ia_name', 150);
            $table->binary('ia_image')->nullable(); // Store as BLOB
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_accounts');
    }
};
