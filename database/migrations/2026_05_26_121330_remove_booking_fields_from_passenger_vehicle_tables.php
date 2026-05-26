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
            if (Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
            if (Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
            }
            if (Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'agent_id')) {
                $table->dropColumn('agent_id');
            }
        });

        // Remove from booked_passengers
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('booked_passengers', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
            if (Schema::connection($this->connection)->hasColumn('booked_passengers', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
            }
            if (Schema::connection($this->connection)->hasColumn('booked_passengers', 'agent_id')) {
                $table->dropColumn('agent_id');
            }
        });

        // Remove from temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
            if (Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
            }
        });

        // Remove from booked_vehicles
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('booked_vehicles', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
            if (Schema::connection($this->connection)->hasColumn('booked_vehicles', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
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
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_passengers', 'agent_id')) {
                $table->unsignedBigInteger('agent_id')->nullable();
            }
        });

        // Add back to booked_passengers
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('booked_passengers', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('booked_passengers', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('booked_passengers', 'agent_id')) {
                $table->unsignedBigInteger('agent_id')->nullable();
            }
        });

        // Add back to temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('temp_booked_vehicles', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
        });

        // Add back to booked_vehicles
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('booked_vehicles', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('booked_vehicles', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
        });
    }
};
