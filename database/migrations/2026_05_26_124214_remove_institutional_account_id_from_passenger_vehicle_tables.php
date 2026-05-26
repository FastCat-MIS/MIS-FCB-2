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
            if (Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'institutional_account_id')) {
                $table->dropColumn('institutional_account_id');
            }
        });

        // Remove from booked_passengers
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('booked_passengers', 'institutional_account_id')) {
                $table->dropColumn('institutional_account_id');
            }
        });

        // Remove from temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'institutional_account_id')) {
                $table->dropColumn('institutional_account_id');
            }
        });

        // Remove from booked_vehicles
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('booked_vehicles', 'institutional_account_id')) {
                $table->dropColumn('institutional_account_id');
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
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'institutional_account_id')) {
                $table->unsignedBigInteger('institutional_account_id')->nullable();
            }
        });

        // Add back to booked_passengers
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('booked_passengers', 'institutional_account_id')) {
                $table->unsignedBigInteger('institutional_account_id')->nullable();
            }
        });

        // Add back to temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'institutional_account_id')) {
                $table->unsignedBigInteger('institutional_account_id')->nullable();
            }
        });

        // Add back to booked_vehicles
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('booked_vehicles', 'institutional_account_id')) {
                $table->unsignedBigInteger('institutional_account_id')->nullable();
            }
        });
    }
};
