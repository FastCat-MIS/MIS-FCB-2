<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->foreignId('route_id')->constrained('routes', 'route_id')->onDelete('cascade');
            $table->string('vessel_id', 50);

            // Store only hours and minutes
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();

            $table->integer('duration')->nullable();
            $table->integer('available_seats')->default(0);
            $table->integer('total_seats')->default(0);
            $table->string('status')->default('scheduled');
            $table->string('operator', 100)->nullable();
            $table->timestamps();

            $table->index('route_id');
            $table->index('departure_time');
            $table->index('status');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
