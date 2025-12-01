<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id('passenger_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id')->onDelete('cascade');
            $table->string('fullname', 200);
            $table->integer('age')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('id_type', 50)->nullable();
            $table->string('id_number', 100)->nullable();
            $table->foreignId('discount_id')->nullable()->constrained('discounts', 'discount_id')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->decimal('vehicle_amount', 10, 2)->default(0);
            $table->string('category', 50)->default('adult');
            $table->string('type', 50)->nullable();
            $table->string('accommodation', 50)->nullable();
            $table->string('seat_number', 10)->nullable();
            $table->text('special_requirements')->nullable();
            $table->timestamps();

            $table->index('booking_id');
            $table->index('discount_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
