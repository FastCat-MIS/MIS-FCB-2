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
            if (!Schema::connection($this->connection)->hasColumn('temp_bookings', 'institutional_account_snapshot')) {
                $table->string('institutional_account_snapshot')->nullable()->after('institutional_account_id');
            }
        });

        // Add to bookings
        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('bookings', 'institutional_account_snapshot')) {
                $table->string('institutional_account_snapshot')->nullable()->after('institutional_account_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->table('temp_bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('temp_bookings', 'institutional_account_snapshot')) {
                $table->dropColumn('institutional_account_snapshot');
            }
        });

        Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('bookings', 'institutional_account_snapshot')) {
                $table->dropColumn('institutional_account_snapshot');
            }
        });
    }
};
