<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'teller_booking';

    public function up(): void
    {
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('institutional_account_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};