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
            if (!Schema::connection($this->connection)->hasColumn('temp_bookings', 'booking_origin')) {
                $table->enum('booking_origin', ['teller', 'public', 'mobile', 'admin', 'api'])
                      ->default('teller')
                      ->after('institutional_account_snapshot');
            }
        });

        // Add to bookings
        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('bookings', 'booking_origin')) {
                $table->enum('booking_origin', ['teller', 'public', 'mobile', 'admin', 'api'])
                      ->default('teller')
                      ->after('institutional_account_snapshot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove from temp_bookings
        Schema::connection($this->connection)->table('temp_bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_bookings', 'booking_origin')) {
                $table->dropColumn('booking_origin');
            }
        });

        // Remove from bookings
        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('bookings', 'booking_origin')) {
                $table->dropColumn('booking_origin');
            }
        });
    }
};
