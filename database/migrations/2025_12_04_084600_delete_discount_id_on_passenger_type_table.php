<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            // Drop the discount_id column if it exists
            if (Schema::hasColumn('passenger_types', 'discount_id')) {
                $table->dropColumn('discount_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('passenger_types', function (Blueprint $table) {
            // Re-add the discount_id column if you want to rollback
            $table->unsignedBigInteger('discount_id')->nullable()->after('type');
        });
    }
};
