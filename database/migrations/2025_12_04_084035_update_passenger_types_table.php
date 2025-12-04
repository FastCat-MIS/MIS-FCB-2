<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->decimal('discount', 5, 2)
                  ->default(0)
                  ->after('type');

            $table->boolean('waived')
                  ->default(false)
                  ->after('discount');

            $table->string('status')
                  ->default('active')
                  ->after('waived');
        });
    }

    public function down(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            $table->dropColumn(['discount', 'waived', 'status']);
        });
    }
};
