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
        Schema::table('professionals', function (Blueprint $table) {
            if (!Schema::hasColumn('professionals', 'specialty')) {
                $table->string('specialty')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('professionals', 'bio')) {
                $table->text('bio')->nullable()->after('specialty');
            }
            if (!Schema::hasColumn('professionals', 'color')) {
                $table->string('color', 7)->default('#6366f1')->after('bio');
            }
            if (!Schema::hasColumn('professionals', 'avatar')) {
                $table->string('avatar')->nullable()->after('color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn(['specialty', 'bio', 'color', 'avatar']);
        });
    }
};

