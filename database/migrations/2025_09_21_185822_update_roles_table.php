<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the roles table exists (it should from Spatie)
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                // Add custom fields to existing Spatie roles table
                if (!Schema::hasColumn('roles', 'description')) {
                    $table->string('description')->nullable()->after('guard_name');
                }
                if (!Schema::hasColumn('roles', 'created_by')) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('description');
                }
                if (!Schema::hasColumn('roles', 'is_system')) {
                    $table->boolean('is_system')->default(false)->after('created_by');
                }

                // Add index for better performance
                $table->index('created_by');
                $table->index('is_system');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (Schema::hasColumn('roles', 'created_by')) {
                    $table->dropForeign(['created_by']);
                }
                $table->dropColumnIfExists('description');
                $table->dropColumnIfExists('created_by');
                $table->dropColumnIfExists('is_system');
            });
        }
    }
};
