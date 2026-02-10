<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vessels', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id')->nullable()->after('id');

            // If you want it as a foreign key, uncomment this:
            // $table->foreign('route_id')->references('id')->on('routes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('vessels', function (Blueprint $table) {
            // If using foreign keys, drop it first
            // $table->dropForeign(['route_id']);

            $table->dropColumn('route_id');
        });
    }
};
