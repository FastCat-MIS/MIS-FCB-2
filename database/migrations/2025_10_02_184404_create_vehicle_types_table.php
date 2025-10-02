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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id('type_id');
            $table->foreignId('group_id')->constrained('vehicle_groups', 'group_id')->onDelete('cascade');
            $table->string('label', 100);
            $table->string('type_code', 50); // e.g., "motorcycle", "lightcar"
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
