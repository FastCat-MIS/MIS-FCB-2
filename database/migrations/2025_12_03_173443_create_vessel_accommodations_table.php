<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vessel_accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vessel_id');
            $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            $table->unsignedBigInteger('accommodation_id');
            $table->foreign('accommodation_id')->references('accommodation_id')->on('passenger_accommodations')->onDelete('cascade');
            $table->unsignedInteger('rows')->default(0);
            $table->unsignedInteger('columns')->default(0);
            $table->unsignedInteger('seats')->default(0);
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
