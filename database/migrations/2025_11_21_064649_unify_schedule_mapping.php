<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Safely drop a foreign key if it exists.
     */
    private function dropForeignIfExists(string $table, string $column)
    {
        $constraint = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
              AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1
        ", [$table, $column]);

        if ($constraint) {
            DB::statement("ALTER TABLE `$table` DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
        }
    }

    public function up(): void
    {
        /**
         * -----------------------------------------------------------
         * 1) Add port_a_id / port_b_id to routes (nullable first)
         * -----------------------------------------------------------
         */
        Schema::table('routes', function (Blueprint $table) {
            $table->unsignedBigInteger('port_a_id')->nullable()->after('port_a');
            $table->unsignedBigInteger('port_b_id')->nullable()->after('port_b');
        });

        /**
         * -----------------------------------------------------------
         * 2) Convert old string columns → port IDs
         * -----------------------------------------------------------
         */
        $routes = DB::table('routes')->get();

        foreach ($routes as $route) {
            $portA = DB::table('ports')->where('port_name', $route->port_a)->first();
            $portB = DB::table('ports')->where('port_name', $route->port_b)->first();

            DB::table('routes')
                ->where('route_id', $route->route_id)
                ->update([
                    'port_a_id' => $portA->port_id ?? null,
                    'port_b_id' => $portB->port_id ?? null,
                ]);
        }

        /**
         * -----------------------------------------------------------
         * 3) Add foreign keys to routes
         * -----------------------------------------------------------
         */
        Schema::table('routes', function (Blueprint $table) {
            $table->foreign('port_a_id')->references('port_id')->on('ports')->onDelete('set null');
            $table->foreign('port_b_id')->references('port_id')->on('ports')->onDelete('set null');
        });

        /**
         * -----------------------------------------------------------
         * 4) Remove old string columns (port_a, port_b)
         * -----------------------------------------------------------
         */
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn(['port_a', 'port_b']);
        });

        /**
         * -----------------------------------------------------------
         * 5) Add route_id to schedules
         * -----------------------------------------------------------
         */
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id')->nullable()->after('vessel');
        });

        /**
         * -----------------------------------------------------------
         * 6) Map schedules to routes (create route if necessary)
         * -----------------------------------------------------------
         */
        $schedules = DB::table('schedules')->get();

        foreach ($schedules as $schedule) {
            if (!$schedule->port_a_id || !$schedule->port_b_id) {
                continue;
            }

            // Find existing matching route
            $route = DB::table('routes')
                ->where('port_a_id', $schedule->port_a_id)
                ->where('port_b_id', $schedule->port_b_id)
                ->first();

            // Create if missing
            if (!$route) {
                $routeId = DB::table('routes')->insertGetId([
                    'port_a_id' => $schedule->port_a_id,
                    'port_b_id' => $schedule->port_b_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $routeId = $route->route_id;
            }

            // Assign schedule to route
            DB::table('schedules')
                ->where('sched_id', $schedule->sched_id)
                ->update(['route_id' => $routeId]);
        }

        /**
         * -----------------------------------------------------------
         * 7) Add foreign key for route_id
         * -----------------------------------------------------------
         */
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('set null');
        });

        /**
         * -----------------------------------------------------------
         * 8) Remove port_a_id / port_b_id from schedules
         * -----------------------------------------------------------
         */
        $this->dropForeignIfExists('schedules', 'port_a_id');
        $this->dropForeignIfExists('schedules', 'port_b_id');

        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'port_a_id')) {
                $table->dropColumn('port_a_id');
            }
            if (Schema::hasColumn('schedules', 'port_b_id')) {
                $table->dropColumn('port_b_id');
            }
        });
    }

    public function down(): void
    {
        // Reverse safely

        $this->dropForeignIfExists('schedules', 'route_id');
        $this->dropForeignIfExists('routes', 'port_a_id');
        $this->dropForeignIfExists('routes', 'port_b_id');

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('route_id');
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->string('port_a')->nullable();
            $table->string('port_b')->nullable();
            $table->dropColumn(['port_a_id', 'port_b_id']);
        });
    }
};
