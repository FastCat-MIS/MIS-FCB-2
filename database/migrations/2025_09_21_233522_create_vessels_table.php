<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vessels', function (Blueprint $table) {
            $table->id();
            $table->string('vessel_name', 100);
            $table->integer('capacity')->nullable();
            $table->decimal('decklane_length_capacity', 8, 2)->default(0.00);
            $table->decimal('weight_capacity', 10, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger("status")->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vessels');
    }
};
