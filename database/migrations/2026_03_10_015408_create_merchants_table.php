<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id('merchant_id');
            $table->string('merchant_name', 150);
            $table->string('merchant_code', 20)->unique();
            $table->string('image')->nullable(); 
            $table->string('address', 150)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password', 150);
            $table->string('contact_number', 20)->nullable();
            $table->string('contact_person', 20)->nullable();
            $table->string('area', 150)->nullable();
            $table->string('payment_mode', 20)->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('effective_date')->nullable();
            $table->timestamp('eoc_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
