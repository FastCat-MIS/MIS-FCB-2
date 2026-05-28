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
        // Rename serial_no to booking_number in temp_bookings
        if (Schema::connection('teller_booking')->hasColumn('temp_bookings', 'serial_no')) {
            Schema::connection('teller_booking')->table('temp_bookings', function (Blueprint $table) {
                $table->renameColumn('serial_no', 'booking_number');
            });
        }

        // Rename serial_no to booking_number in bookings
        if (Schema::connection('teller_booking')->hasColumn('bookings', 'serial_no')) {
            Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
                $table->renameColumn('serial_no', 'booking_number');
            });
        }

        // Rename serial_no to booking_number in schedule_seat_locks
        if (Schema::connection('teller_booking')->hasColumn('schedule_seat_locks', 'serial_no')) {
            Schema::connection('teller_booking')->table('schedule_seat_locks', function (Blueprint $table) {
                $table->renameColumn('serial_no', 'booking_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: booking_number back to serial_no in temp_bookings
        if (Schema::connection('teller_booking')->hasColumn('temp_bookings', 'booking_number')) {
            Schema::connection('teller_booking')->table('temp_bookings', function (Blueprint $table) {
                $table->renameColumn('booking_number', 'serial_no');
            });
        }

        // Reverse: booking_number back to serial_no in bookings
        if (Schema::connection('teller_booking')->hasColumn('bookings', 'booking_number')) {
            Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
                $table->renameColumn('booking_number', 'serial_no');
            });
        }

        // Reverse: booking_number back to serial_no in schedule_seat_locks
        if (Schema::connection('teller_booking')->hasColumn('schedule_seat_locks', 'booking_number')) {
            Schema::connection('teller_booking')->table('schedule_seat_locks', function (Blueprint $table) {
                $table->renameColumn('booking_number', 'serial_no');
            });
        }
    }
};
