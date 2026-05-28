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
     * 
     * Clean up teller_booking database - keep ONLY transaction tables.
     * Reference data (users, vessels, schedules, etc.) should be in main database.
     */
    public function up(): void
    {
        // Tables that should STAY in teller_booking
        $keepTables = [
            'migrations',
            'temp_bookings',
            'temp_booked_passengers',
            'temp_booked_vehicles',
            'bookings',
            'booked_passengers',
            'booked_vehicles',
            'booking_payments',
            'schedule_seat_locks',
        ];

        // Disable foreign key checks
        DB::connection($this->connection)->statement('SET FOREIGN_KEY_CHECKS=0;');

        // Get all tables in teller_booking database
        $tables = DB::connection($this->connection)
            ->select('SHOW TABLES');
        
        $databaseName = DB::connection($this->connection)->getDatabaseName();
        $tableKey = "Tables_in_{$databaseName}";

        // Drop all tables except the ones we want to keep
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            if (!in_array($tableName, $keepTables)) {
                echo "Dropping unnecessary table: {$tableName}\n";
                Schema::connection($this->connection)->dropIfExists($tableName);
            }
        }

        // Re-enable foreign key checks
        DB::connection($this->connection)->statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "\n✅ Cleanup complete! Teller booking database now contains only transaction tables.\n";
        echo "Reference data (users, vessels, schedules, etc.) should be accessed from main database.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse - tables are permanently dropped
        echo "⚠️  Cannot restore dropped tables. Backup should be used if restoration needed.\n";
    }
};
