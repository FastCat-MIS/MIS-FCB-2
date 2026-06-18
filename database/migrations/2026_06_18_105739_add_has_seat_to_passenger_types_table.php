<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->boolean('has_seat')->default(true)->after('waived');
        });
    }

    public function down(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->dropColumn('has_seat');
        });
    }
};
