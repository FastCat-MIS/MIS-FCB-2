<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id('discount_id');
            $table->string('discount_name', 225);
            $table->string('discount_code', 100);
            $table->decimal('discount_value', 5, 2)->default(0.00);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->date("effective_date")->nullable();            
            $table->date('end_date')->nullable();
            $table->string("status", 100)->nullable()->default('active');
            $table->timestamps();      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
