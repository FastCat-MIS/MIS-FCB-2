<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('sched_id')->nullable()->constrained('schedules', 'sched_id')->onDelete('set null');
            $table->string('booking_number')->unique();
            $table->date('booking_date');
            $table->string('booking_source', 50);
            $table->foreignId('vehicle_id')->nullable();
            // ->constrained('vehicles', 'id')->onDelete('set null');
            $table->string('plate_number', 20)->nullable();
            $table->boolean('is_connecting_trip')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
