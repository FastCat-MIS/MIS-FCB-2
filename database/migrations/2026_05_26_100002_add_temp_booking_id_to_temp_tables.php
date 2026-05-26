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
        // Add temp_booking_id to temp_booked_passengers
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            if (!Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'temp_booking_id')) {
                $table->unsignedBigInteger('temp_booking_id')->nullable()->after('booked_passenger_id');
                $table->index('temp_booking_id');
            }
        });

        // Add temp_booking_id to temp_booked_vehicles
        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'temp_booking_id')) {
                $table->unsignedBigInteger('temp_booking_id')->nullable()->after('booked_vehicle_id');
                $table->index('temp_booking_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            $table->dropIndex(['temp_booking_id']);
            $table->dropColumn('temp_booking_id');
        });

        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->dropIndex(['temp_booking_id']);
            $table->dropColumn('temp_booking_id');
        });
    }
};
