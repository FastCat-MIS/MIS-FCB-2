<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id('route_id');
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->integer('distance')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['origin', 'destination']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
