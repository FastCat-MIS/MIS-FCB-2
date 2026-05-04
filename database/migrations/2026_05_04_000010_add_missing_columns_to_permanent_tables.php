<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        // Add missing columns to permanent booked_passengers table
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            $table->string('serial_no', 50)->after('booked_passenger_id');
            $table->timestamp('expires_at')->nullable()->after('institutional_account_id');
        });

        // Add missing columns to permanent booked_vehicles table
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->string('serial_no', 50)->after('booked_vehicle_id');
            $table->timestamp('expires_at')->nullable()->after('institutional_account_id');
        });
    }

    public function down(): void
    {
        // Remove the added columns if rolling back
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            $table->dropColumn(['serial_no', 'expires_at']);
        });

        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->dropColumn(['serial_no', 'expires_at']);
        });
    }
};