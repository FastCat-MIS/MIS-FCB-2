<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ia_discounts', function (Blueprint $table) {
            $table->id("ia_discount_id");
            $table->foreignId("ia_id")->constrained("institutional_accounts", "ia_id")->onDelete("cascade");
            $table->foreignId("route_id")->constrained("routes", "route_id")->onDelete("cascade");
            $table->string("discount_name", 255)->nullable();
            $table->decimal('discount_value', 10, 2)->default(0.00)->nullable();            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->timestamp("effective_date")->nullable();
            $table->string("status", 100)->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia_discounts');
    }
};
