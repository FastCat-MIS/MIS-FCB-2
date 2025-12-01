<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectingTripsTable extends Migration
{
    public function up()
    {
        Schema::create('connecting_trips', function (Blueprint $table) {
            $table->id('connecting_id');
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('schedule_id');
            $table->integer('leg');
            $table->unsignedBigInteger('route_id');
            $table->timestamps();

            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
            $table->foreign('schedule_id')->references('sched_id')->on('schedules')->onDelete('cascade');
            $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('cascade');

            $table->unique(['booking_id', 'schedule_id', 'leg']); // optional: prevent duplicates
        });
    }

    public function down()
    {
        Schema::dropIfExists('connecting_trips');
    }
}
