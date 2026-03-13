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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('promo_id');
            $table->string('promo_name', 100);
            $table->string('promo_code', 50);
            $table->decimal('promo_value', 10, 2);
            $table->enum('promo_type', ['percentage', 'fixed']);
            $table->date("effective_date")->nullable();            
            $table->date('end_date')->nullable();
            $table->string("status", 100)->nullable()->default('active');
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
