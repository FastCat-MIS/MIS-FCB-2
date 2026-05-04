<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        // Rename current teller tables to temporary versions
        Schema::connection($this->connection)->rename('booked_passengers', 'temp_booked_passengers');
        Schema::connection($this->connection)->rename('booked_vehicles', 'temp_booked_vehicles');
    }

    public function down(): void
    {
        // Revert the renames
        Schema::connection($this->connection)->rename('temp_booked_passengers', 'booked_passengers');
        Schema::connection($this->connection)->rename('temp_booked_vehicles', 'booked_vehicles');
    }
};