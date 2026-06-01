<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->decimal('convenience_fee', 10, 2)->default(25.00)->after('fare');
        });

        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->decimal('convenience_fee', 10, 2)->default(25.00)->after('fare');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->dropColumn('convenience_fee');
        });

        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->dropColumn('convenience_fee');
        });
    }
};
