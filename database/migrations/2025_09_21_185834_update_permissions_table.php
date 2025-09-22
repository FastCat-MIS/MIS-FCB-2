<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Add module, action, type fields to Spatie's permissions table
            $table->string('module')->nullable()->after('guard_name');
            $table->string('action')->nullable()->after('module');
            $table->string('type')->nullable()->after('action');
            $table->string('description')->nullable()->after('type');

            // Add indexes for better query performance
            $table->index('module');
            $table->index('action');
            $table->index('type');
        });

        // Update existing permissions to include module and action
        $permissions = [
            'create users' => ['module' => 'users', 'action' => 'create', 'type' => 'operation'],
            'edit users' => ['module' => 'users', 'action' => 'edit', 'type' => 'operation'],
            'delete users' => ['module' => 'users', 'action' => 'delete', 'type' => 'operation'],
            'view users' => ['module' => 'users', 'action' => 'view', 'type' => 'operation'],
        ];

        foreach ($permissions as $name => $data) {
            \Illuminate\Support\Facades\DB::table('permissions')
                ->where('name', $name)
                ->update($data);
        }
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['module', 'action', 'type', 'description']);
        });
    }
};
