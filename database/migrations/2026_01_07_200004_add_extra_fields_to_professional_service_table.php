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
        Schema::table('professional_service', function (Blueprint $table) {
            if (!Schema::hasColumn('professional_service', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('professional_service', 'duration')) {
                $table->integer('duration')->nullable();
            }
            if (!Schema::hasColumn('professional_service', 'available_slots')) {
                $table->json('available_slots')->nullable();
            }
            if (!Schema::hasColumn('professional_service', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('professional_service', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_service', function (Blueprint $table) {
            if (Schema::hasColumn('professional_service', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('professional_service', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('professional_service', 'available_slots')) {
                $table->dropColumn('available_slots');
            }
            if (Schema::hasColumn('professional_service', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('professional_service', 'created_at')) {
                $table->dropColumn(['created_at', 'updated_at']);
            }
        });
    }
};

