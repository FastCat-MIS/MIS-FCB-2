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
        // Remove from temp_booked_passengers
        Schema::connection($this->connection)->table('temp_booked_passengers', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'booking_id')) {
                $table->dropColumn('booking_id');
            }
        });

        // Remove from temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'booking_id')) {
                $table->dropColumn('booking_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back to temp_booked_passengers
        Schema::connection($this->connection)->table('temp_booked_passengers', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('temp_booking_id');
            }
        });

        // Add back to temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('temp_booking_id');
            }
        });
    }
};
