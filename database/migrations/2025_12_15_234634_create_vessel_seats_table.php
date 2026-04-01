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
        Schema::create('vessel_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vessel_accommodation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('seat_no');
            $table->integer('row');
            $table->integer('col');
            $table->boolean('blocked')->default(false);
            $table->boolean('path')->default(false);
            $table->boolean('pwd')->default(false);
            $table->string('facility')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('vessel_seats');
    }
};
