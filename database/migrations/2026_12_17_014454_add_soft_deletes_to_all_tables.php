<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->softDeletes();
        });


        Schema::table('bookings', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('connecting_trips', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('passengers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('passenger_accommodations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('passenger_categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('passenger_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('vessels', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('add_ons', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('vehicle_rates', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('accommodation_rates', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('institutional_accounts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ia_discounts', function (Blueprint $table) {
            $table->softDeletes();
        });


    }

    public function down(): void
    {


        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('connecting_trips', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('passengers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('passenger_accommodations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('passenger_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('passenger_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('vessels', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('add_ons', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('vehicle_rates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('accommodation_rates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('institutional_accounts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('ia_discounts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });



    }
};
