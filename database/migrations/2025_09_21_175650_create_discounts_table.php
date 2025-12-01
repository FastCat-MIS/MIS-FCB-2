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
            $table->string('discount_type', 100);
            $table->string('discount_code', 50)->unique();
            $table->decimal('discount_percentage', 5, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();      // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
