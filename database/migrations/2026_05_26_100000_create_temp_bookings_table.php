<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('teller_booking')->create('temp_bookings', function (Blueprint $table) {
            $table->id('temp_booking_id');
            $table->string('serial_no')->unique();
            $table->date('travel_date');
            
            // Schedule reference and snapshot
            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot')->nullable();
            
            // Route reference and snapshot
            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot')->nullable();
            
            // Vessel snapshot
            $table->string('vessel_snapshot')->nullable();
            
            // Audit fields
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            // Indexes
            $table->index('serial_no');
            $table->index('travel_date');
            $table->index('schedule_id');
            $table->index('route_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_booking')->dropIfExists('temp_bookings');
    }
};
