<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->time('departure_time')->nullable()->change();
            $table->time('arrival_time')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dateTime('departure_time')->nullable()->change();
            $table->dateTime('arrival_time')->nullable()->change();
        });
    }

};
