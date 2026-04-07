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
        Schema::create('vdar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vessel_id')->constrained('vessels')->cascadeOnDelete();
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')->references('sched_id')->on('schedules')->cascadeOnDelete();
            $table->foreignId('vessel_master_id')->constrained('users')->cascadeOnDelete();
            $table->integer('voyage_number');
            $table->integer('recorded_sailing_speed');
            $table->integer('water_consumption');
            $table->integer('fuel_rob');
            $table->string('reason_of_delay')->nullable();
            $table->dateTime('actual_departure_time')->nullable();
            $table->dateTime('actual_arrival_time')->nullable();
            $table->dateTime('ram_disengage_time')->nullable();
            $table->dateTime('undock_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vdar');
    }
};
