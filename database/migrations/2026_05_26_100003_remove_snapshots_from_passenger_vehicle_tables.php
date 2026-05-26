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
        // Remove snapshots from temp_booked_passengers
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            $columnsToRemove = [];
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'travel_date')) {
                $columnsToRemove[] = 'travel_date';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'schedule_id')) {
                $columnsToRemove[] = 'schedule_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'schedule_snapshot')) {
                $columnsToRemove[] = 'schedule_snapshot';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'route_id')) {
                $columnsToRemove[] = 'route_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'route_snapshot')) {
                $columnsToRemove[] = 'route_snapshot';
            }
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });

        // Remove snapshots from temp_booked_vehicles
        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            $columnsToRemove = [];
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'travel_date')) {
                $columnsToRemove[] = 'travel_date';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'schedule_id')) {
                $columnsToRemove[] = 'schedule_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'schedule_snapshot')) {
                $columnsToRemove[] = 'schedule_snapshot';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'route_id')) {
                $columnsToRemove[] = 'route_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'route_snapshot')) {
                $columnsToRemove[] = 'route_snapshot';
            }
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });

        // Remove snapshots from booked_passengers (permanent)
        Schema::connection('teller_booking')->table('booked_passengers', function (Blueprint $table) {
            $columnsToRemove = [];
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'travel_date')) {
                $columnsToRemove[] = 'travel_date';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'schedule_id')) {
                $columnsToRemove[] = 'schedule_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'schedule_snapshot')) {
                $columnsToRemove[] = 'schedule_snapshot';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'route_id')) {
                $columnsToRemove[] = 'route_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'route_snapshot')) {
                $columnsToRemove[] = 'route_snapshot';
            }
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });

        // Remove snapshots from booked_vehicles (permanent)
        Schema::connection('teller_booking')->table('booked_vehicles', function (Blueprint $table) {
            $columnsToRemove = [];
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'travel_date')) {
                $columnsToRemove[] = 'travel_date';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'schedule_id')) {
                $columnsToRemove[] = 'schedule_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'schedule_snapshot')) {
                $columnsToRemove[] = 'schedule_snapshot';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'route_id')) {
                $columnsToRemove[] = 'route_id';
            }
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'route_snapshot')) {
                $columnsToRemove[] = 'route_snapshot';
            }
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back snapshots to temp_booked_passengers
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            $table->date('travel_date');
            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot')->nullable();
            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot')->nullable();
        });

        // Add back snapshots to temp_booked_vehicles
        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->date('travel_date');
            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot')->nullable();
            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot')->nullable();
        });

        // Add back snapshots to booked_passengers
        Schema::connection('teller_booking')->table('booked_passengers', function (Blueprint $table) {
            $table->date('travel_date');
            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot')->nullable();
            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot')->nullable();
        });

        // Add back snapshots to booked_vehicles
        Schema::connection('teller_booking')->table('booked_vehicles', function (Blueprint $table) {
            $table->date('travel_date');
            $table->unsignedBigInteger('schedule_id');
            $table->time('schedule_snapshot')->nullable();
            $table->unsignedBigInteger('route_id');
            $table->string('route_snapshot')->nullable();
        });
    }
};
