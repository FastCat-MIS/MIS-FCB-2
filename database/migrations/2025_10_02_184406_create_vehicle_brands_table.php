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
        Schema::create('vehicle_brands', function (Blueprint $table) {
            $table->id('brand_id');
            $table->foreignId('type_id')->constrained('vehicle_types', 'type_id')->onDelete('cascade');
            $table->string('label', 100); // e.g., "Yamaha", "Honda"
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_brands');
    }
};
