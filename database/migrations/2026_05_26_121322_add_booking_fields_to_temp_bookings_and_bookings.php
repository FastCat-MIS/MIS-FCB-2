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
        // Add to temp_bookings
        Schema::connection($this->connection)->table('temp_bookings', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('temp_bookings', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('serial_no');
            }
            if (!Schema::connection($this->connection)->hasColumn('temp_bookings', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
        });

        // Add to bookings
        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('bookings', 'schedule_booking_id')) {
                $table->unsignedBigInteger('schedule_booking_id')->nullable()->after('booking_id');
            }
            if (!Schema::connection($this->connection)->hasColumn('bookings', 'is_return_trip')) {
                $table->boolean('is_return_trip')->default(false)->after('schedule_booking_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->table('temp_bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_bookings', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
            }
            if (Schema::connection($this->connection)->hasColumn('temp_bookings', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
        });

        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('bookings', 'is_return_trip')) {
                $table->dropColumn('is_return_trip');
            }
            if (Schema::connection($this->connection)->hasColumn('bookings', 'schedule_booking_id')) {
                $table->dropColumn('schedule_booking_id');
            }
        });
    }
};
