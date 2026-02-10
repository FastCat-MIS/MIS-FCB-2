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
                  ->comment('0=None, 1=Online, 2=Walk-in, 3=Online/Walk-in, 4=Merchant, 5=Online/Merchant, 6=Merchant/Walk-in, 7=All');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
