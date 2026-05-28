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
        Schema::connection('teller_booking')->table('schedule_seat_locks', function (Blueprint $table) {
            // Make expires_at nullable so permanent bookings can have null (no expiration)
            $table->timestamp('expires_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('teller_booking')->table('schedule_seat_locks', function (Blueprint $table) {
            // Revert to NOT NULL
            $table->timestamp('expires_at')->nullable(false)->change();
        });
    }
};
