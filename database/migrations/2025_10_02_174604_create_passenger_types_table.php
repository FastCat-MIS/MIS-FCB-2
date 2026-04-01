<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passenger_types', function (Blueprint $table) {
            $table->id('p_id');
            $table->string('type')->unique();
            $table->decimal('discount', 5, 2)
                  ->default(0);
            $table->boolean('waived')
                  ->default(false);
            $table->unsignedTinyInteger('status')
                  ->default(0); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passenger_types');
    }
};
