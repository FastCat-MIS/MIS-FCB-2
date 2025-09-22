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
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('max_usage')->nullable();
            $table->integer('current_usage')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('discount_code');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
