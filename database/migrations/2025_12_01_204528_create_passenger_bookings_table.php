<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booked_passengers', function (Blueprint $table) {
            $table->id('passenger_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id')->onDelete('cascade');
            $table->string('fullname');
            $table->foreignId('discount_id')->nullable()->constrained('discounts', 'discount_id')->onDelete('set null');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('vehicle_amount', 10, 2)->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('accommodation_id')->nullable()->constrained('passenger_accommodations', 'accommodation_id')->onDelete('set null');
            $table->string('gender')->nullable();
            $table->string('seat')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booked_passengers');
    }
};
