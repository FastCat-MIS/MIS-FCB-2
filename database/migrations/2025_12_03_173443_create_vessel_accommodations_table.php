<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vessel_accommodations', function (Blueprint $table) {
            $table->id('id');

            // Foreign key to vessels
            $table->unsignedBigInteger('vessel_id');
            $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');

            // Foreign key to passenger accommodations
            $table->unsignedBigInteger('accommodation_id');
            $table->foreign('accommodation_id')->references('accommodation_id')->on('passenger_accommodations')->onDelete('cascade');

            // Additional attributes
            $table->integer('seats')->default(0);
            $table->boolean('aircon')->default(false);
            $table->boolean('wifi')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vessel_accommodations');
    }
};
