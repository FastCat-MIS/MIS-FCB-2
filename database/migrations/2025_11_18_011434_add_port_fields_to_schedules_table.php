<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Add columns as nullable first
            $table->unsignedBigInteger('port_a_id')->nullable()->after('vessel');
            $table->unsignedBigInteger('port_b_id')->nullable()->after('port_a_id');
        });

        Schema::table('schedules', function (Blueprint $table) {
            // Add foreign keys AFTER table exists with valid data
            $table->foreign('port_a_id')
                ->references('port_id')
                ->on('ports')
                ->onDelete('set null');

            $table->foreign('port_b_id')
                ->references('port_id')
                ->on('ports')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['port_a_id']);
            $table->dropForeign(['port_b_id']);

            // Drop columns
            $table->dropColumn(['port_a_id', 'port_b_id']);
        });
    }
};
