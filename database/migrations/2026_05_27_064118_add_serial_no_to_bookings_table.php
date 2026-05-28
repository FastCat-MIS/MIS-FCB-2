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
        Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
            if (!Schema::connection('teller_booking')->hasColumn('bookings', 'serial_no')) {
                $table->string('serial_no', 50)->nullable()->after('booking_id');
                $table->index('serial_no');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_booking')->table('bookings', function (Blueprint $table) {
            if (Schema::connection('teller_booking')->hasColumn('bookings', 'serial_no')) {
                $table->dropColumn('serial_no');
            }
        });
    }
};
