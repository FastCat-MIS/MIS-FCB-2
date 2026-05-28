<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_passengers', 'serial_no')) {
                $table->dropColumn('serial_no');
            }
        });

        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('temp_booked_vehicles', 'serial_no')) {
                $table->dropColumn('serial_no');
            }
        });

        Schema::connection('teller_booking')->table('booked_passengers', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('booked_passengers', 'serial_no')) {
                $table->dropColumn('serial_no');
            }
        });

        Schema::connection('teller_booking')->table('booked_vehicles', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('booked_vehicles', 'serial_no')) {
                $table->dropColumn('serial_no');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_booking')->table('temp_booked_passengers', function (Blueprint $table) {
            $table->string('serial_no', 50)->nullable()->after('temp_booking_id');
        });

        Schema::connection('teller_booking')->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->string('serial_no', 50)->nullable()->after('temp_booking_id');
        });

        Schema::connection('teller_booking')->table('booked_passengers', function (Blueprint $table) {
            $table->string('serial_no', 50)->nullable()->after('booking_id');
        });

        Schema::connection('teller_booking')->table('booked_vehicles', function (Blueprint $table) {
            $table->string('serial_no', 50)->nullable()->after('booking_id');
        });
    }
};
