<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure booking_number has unique index on bookings table
        if (!$this->hasIndex('bookings', 'bookings_booking_number_unique')) {
            Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
                $table->unique('booking_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->hasIndex('bookings', 'bookings_booking_number_unique')) {
            Schema::connection($this->connection)->table('bookings', function (Blueprint $table) {
                $table->dropUnique('bookings_booking_number_unique');
            });
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $indexes = DB::connection($this->connection)
            ->select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        
        return count($indexes) > 0;
    }
};
