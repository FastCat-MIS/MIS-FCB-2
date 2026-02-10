<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedTinyInteger('visibility')
                  ->default(7)
                  ->comment('1=Online, 2=Walk-in, 3=Merchant, 4=Online/Walk-in, 5=Online/Merchant, 6=Walk-in/Merchant, 7=All');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
