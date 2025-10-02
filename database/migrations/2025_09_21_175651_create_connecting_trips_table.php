<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connecting_trips', function (Blueprint $table) {
            $table->id('connecting_id');
            $table->string('booking_number');
            $table->foreignId('sched_id')->constrained('schedules', 'sched_id')->onDelete('cascade');
            $table->integer('leg');
            $table->string('route', 100);

            // Change timestamp to DateTime to avoid MySQL issues
            $table->dateTime('departure_time')->nullable(); // Changed to DateTime
            $table->dateTime('arrival_time')->nullable();   // Changed to DateTime

            $table->timestamps();

            $table->index('booking_number');
            $table->index('sched_id');
            $table->foreign('booking_number')->references('booking_number')->on('bookings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connecting_trips');
    }
};
