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
        Schema::connection($this->connection)->table('schedule_seat_locks', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('schedule_seat_locks', 'vessel_id')) {
                $table->unsignedBigInteger('vessel_id')->nullable()->after('travel_date');
            }
            if (!Schema::connection($this->connection)->hasColumn('schedule_seat_locks', 'vessel_snapshot')) {
                $table->string('vessel_snapshot')->nullable()->after('vessel_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->table('schedule_seat_locks', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('schedule_seat_locks', 'vessel_snapshot')) {
                $table->dropColumn('vessel_snapshot');
            }
            if (Schema::connection($this->connection)->hasColumn('schedule_seat_locks', 'vessel_id')) {
                $table->dropColumn('vessel_id');
            }
        });
    }
};
