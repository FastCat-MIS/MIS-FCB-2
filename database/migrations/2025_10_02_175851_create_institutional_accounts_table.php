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
            $table->string('image')->nullable(); 
            $table->string('address', 150)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password', 150);
            $table->string('contact_number', 20)->nullable();
            $table->string('contact_person', 20)->nullable();
            $table->string('area', 150)->nullable();
            $table->string('payment_mode', 20)->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->string('status', 100)->default('inactive')->nullable();
            $table->timestamp('effective_date')->nullable();
            $table->timestamp('eoc_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_accounts');
    }
};
