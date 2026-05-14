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
        // Add created_by to temp_booked_passengers
        Schema::connection($this->connection)->table('temp_booked_passengers', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('institutional_account_id');
            $table->index('created_by');
        });

        // Add created_by to temp_booked_vehicles
        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('institutional_account_id');
            $table->index('created_by');
        });

        // Add created_by to booked_passengers (permanent)
        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('institutional_account_id');
            $table->index('created_by');
        });

        // Add created_by to booked_vehicles (permanent)
        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('institutional_account_id');
            $table->index('created_by');
        });

        // Add created_by to booking_payments
        Schema::connection($this->connection)->table('booking_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('payment_method');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->table('temp_booked_passengers', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::connection($this->connection)->table('temp_booked_vehicles', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::connection($this->connection)->table('booked_passengers', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::connection($this->connection)->table('booked_vehicles', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::connection($this->connection)->table('booking_payments', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
