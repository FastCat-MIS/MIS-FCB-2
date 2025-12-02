<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {
            // Add route_id column if it doesn't exist
            if (!Schema::hasColumn('ports', 'route_id')) {
                $table->unsignedBigInteger('route_id')->nullable()->after('ramp_status');
                $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {
            $table->dropForeign(['route_id']);
            $table->dropColumn('route_id');
        });
    }
};
