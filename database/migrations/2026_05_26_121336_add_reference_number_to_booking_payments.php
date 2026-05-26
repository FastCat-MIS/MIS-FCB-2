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
        Schema::connection($this->connection)->table('booking_payments', function (Blueprint $table) {
            if (!Schema::connection($this->connection)->hasColumn('booking_payments', 'reference_number')) {
                $table->string('reference_number', 100)->nullable()->after('payment_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->table('booking_payments', function (Blueprint $table) {
            if (Schema::connection($this->connection)->hasColumn('booking_payments', 'reference_number')) {
                $table->dropColumn('reference_number');
            }
        });
    }
};
