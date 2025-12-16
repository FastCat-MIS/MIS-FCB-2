<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('vessel_facility_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vessel_accommodation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->integer('top');
            $table->integer('left');
            $table->integer('width');
            $table->integer('height');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vessel_facility_labels');
    }
};
