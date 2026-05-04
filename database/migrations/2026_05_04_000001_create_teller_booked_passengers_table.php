<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        Schema::connection($this->connection)->create('booked_passengers', function (Blueprint $table) {
            $table->id('booked_passenger_id');

            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('schedule_booking_id')->nullable();
            $table->boolean('is_return_trip')->default(false);

            $table->date('travel_date');

            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot');

            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot', 255);

            $table->string('fullname', 255);
            $table->string('gender', 20)->nullable();

            $table->unsignedBigInteger('passenger_type_id');
            $table->string('passenger_type_snapshot', 100);

            $table->unsignedBigInteger('passenger_category_id')->nullable();
            $table->string('passenger_category_snapshot', 100)->nullable();

            $table->unsignedBigInteger('seat_id')->nullable();
            $table->string('seat_number_snapshot', 20)->nullable();

            $table->unsignedBigInteger('agent_id')->nullable();

            $table->decimal('fare', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->unsignedBigInteger('discount_id')->nullable();

            $table->unsignedBigInteger('institutional_account_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['booking_id', 'travel_date']);
            $table->index(['schedule_id', 'route_id']);
            $table->index(['seat_id']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('booked_passengers');
    }
};

