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
            $table->foreignId('sched_id')->constrained('schedules', 'sched_id')->onDelete('cascade');
            $table->string('booking_number')->unique();
            $table->timestamp('booking_date');
            $table->string('booking_source', 50);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name', 200);
            $table->string('customer_email', 150);
            $table->string('customer_phone', 20);
            $table->string('vehicle_id', 50)->nullable();
            $table->string('plate_number', 20)->nullable();
            $table->boolean('is_connecting_trip')->default(false);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_status')->default('pending');
            $table->string('booking_status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('booking_number');
            $table->index('sched_id');
            $table->index('user_id');
            $table->index('booking_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
