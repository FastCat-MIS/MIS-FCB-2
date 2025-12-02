<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Add port_id column
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('port_id')->nullable()->after('vessel_id');
        });

        // 2️⃣ Migrate existing data
        $schedules = DB::table('schedules')->get();

        foreach ($schedules as $schedule) {
            // Get Route of schedule
            $route = DB::table('routes')->where('route_id', $schedule->route_id)->first();

            if ($route && $route->port_a_id) {
                DB::table('schedules')
                    ->where('sched_id', $schedule->sched_id)
                    ->update(['port_id' => $route->port_a_id]);
            }
        }

        // 3️⃣ Add foreign key
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('port_id')->references('port_id')->on('ports')->onDelete('set null');
        });

        // 4️⃣ Optionally remove old route_id
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['route_id']);
            $table->dropColumn('route_id');
        });
    }

    public function down(): void
    {
        // 1️⃣ Add back route_id
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id')->nullable()->after('vessel_id');
        });

        // 2️⃣ Restore data: try to get route from port
        $schedules = DB::table('schedules')->get();

        foreach ($schedules as $schedule) {
            $port = DB::table('ports')->where('port_id', $schedule->port_id)->first();
            if ($port && $port->route_id) {
                DB::table('schedules')
                    ->where('sched_id', $schedule->sched_id)
                    ->update(['route_id' => $port->route_id]);
            }
        }

        // 3️⃣ Add foreign key back
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('set null');
        });

        // 4️⃣ Drop port_id
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['port_id']);
            $table->dropColumn('port_id');
        });
    }
};
