<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id')
                ->nullable()
                ->default(0)
                ->after('type');
        });
    }

    public function down()
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->dropColumn('discount_id');
        });
    }
};
