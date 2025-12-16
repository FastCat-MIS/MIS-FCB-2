<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vessel_accommodations', function (Blueprint $table) {
            $table->unsignedInteger('rows')->default(0);
            $table->unsignedInteger('columns')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('vessel_accommodations', function (Blueprint $table) {
            $table->dropColumn(['rows', 'columns']);
        });
    }
};
