<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if name column exists (it might have been renamed already)
            $hasNameColumn = Schema::hasColumn('users', 'name');

            // Add first_name and last_name
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->after('id')->nullable();
            }

            if (!Schema::hasColumn('users', 'middle_name')) {
                $table->string('middle_name')->after('id')->nullable();
            }

            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->after('first_name')->nullable();
            }

            // Add phone and address
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }

            // Add status field
            if (!Schema::hasColumn('users', 'status')) {
                $table->boolean('status')->default(true)->after('address');
            }

            // Add role_id foreign key
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null')->after('last_name');
            }
        });

        // Only update if name column exists
        if (Schema::hasColumn('users', 'name')) {
            \Illuminate\Support\Facades\DB::table('users')->update([
                'first_name' => \Illuminate\Support\Facades\DB::raw('name'),
                'last_name' => ''
            ]);

            // Optionally rename the name column to avoid confusion
            // Schema::table('users', function (Blueprint $table) {
            //     $table->renameColumn('name', 'old_name');
            // });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key first
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
            }

            $table->dropColumnIfExists('first_name');
            $table->dropColumnIfExists('middle_name');
            $table->dropColumnIfExists('last_name');
            $table->dropColumnIfExists('phone');
            $table->dropColumnIfExists('address');
            $table->dropColumnIfExists('status');
            $table->dropColumnIfExists('role_id');

            // If you renamed name column, restore it
            // if (Schema::hasColumn('users', 'old_name')) {
            //     $table->renameColumn('old_name', 'name');
            // }
        });
    }
};
