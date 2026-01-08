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
        Schema::table('service_schedules', function (Blueprint $table) {
            // JSON field to store selected available slots
            // If null, all generated slots are available
            // If set, only the listed slots are available
            $table->json('available_slots')->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_schedules', function (Blueprint $table) {
            $table->dropColumn('available_slots');
        });
    }
};
