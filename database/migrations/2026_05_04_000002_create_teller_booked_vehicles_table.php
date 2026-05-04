<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        Schema::connection($this->connection)->create('booked_vehicles', function (Blueprint $table) {
            $table->id('booked_vehicle_id');

            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('schedule_booking_id')->nullable();
            $table->boolean('is_return_trip')->default(false);

            $table->date('travel_date');

            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot');

            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot', 255);

            $table->string('vehicle_type', 50);
            $table->string('plate_no', 20);
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('fare', 10, 2);

            $table->unsignedBigInteger('driver_passenger_booking_id')->nullable();
            $table->unsignedBigInteger('institutional_account_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['booking_id', 'travel_date']);
            $table->index(['schedule_id', 'route_id']);
            $table->index(['plate_no']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('booked_vehicles');
    }
};

