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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->tinyInteger('vehicle_type');
            $table->string('vehicle_class');
            $table->decimal('weight', 8, 3)->default(0.000); 
            $table->decimal('length', 10, 2)->default(0.00); 

            $table->timestamps();

             $table->unique(['vehicle_type', 'vehicle_class']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
