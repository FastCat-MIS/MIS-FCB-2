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
            $table->string('discount_cn', 100)->unique();
            $table->string('discount_name', 225);
            $table->string('discount_code', 100);
            $table->decimal('discount_value', 10, 2)->default(0.00);
            $table->unsignedTinyInteger('value_type');
            $table->boolean('is_roundtrip')->default(0);
            $table->boolean('with_condition')->default(0);
            $table->date("effective_date")->nullable();            
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger("status")->default(0);
            $table->timestamps();      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
