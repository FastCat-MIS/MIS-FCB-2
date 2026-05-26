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
        // Remove port snapshots from temp_bookings
        Schema::connection('teller_booking')->table('temp_bookings', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('temp_bookings', 'origin_port_snapshot')) {
                $table->dropColumn('origin_port_snapshot');
            }
            if (Schema::connection('teller_booking')->hasColumn('temp_bookings', 'destination_port_snapshot')) {
                $table->dropColumn('destination_port_snapshot');
            }
        });

        // Remove port snapshots from bookings
        Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('bookings', 'origin_port_snapshot')) {
                $table->dropColumn('origin_port_snapshot');
            }
            if (Schema::connection('teller_booking')->hasColumn('bookings', 'destination_port_snapshot')) {
                $table->dropColumn('destination_port_snapshot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back port snapshots to temp_bookings
        Schema::connection('teller_booking')->table('temp_bookings', function (Blueprint $table) {
            if (!Schema::connection('teller_booking')->hasColumn('temp_bookings', 'origin_port_snapshot')) {
                $table->string('origin_port_snapshot')->nullable();
            }
            if (!Schema::connection('teller_booking')->hasColumn('temp_bookings', 'destination_port_snapshot')) {
                $table->string('destination_port_snapshot')->nullable();
            }
        });

        // Add back port snapshots to bookings
        Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
            if (!Schema::connection('teller_booking')->hasColumn('bookings', 'origin_port_snapshot')) {
                $table->string('origin_port_snapshot')->nullable();
            }
            if (!Schema::connection('teller_booking')->hasColumn('bookings', 'destination_port_snapshot')) {
                $table->string('destination_port_snapshot')->nullable();
            }
        });
    }
};
