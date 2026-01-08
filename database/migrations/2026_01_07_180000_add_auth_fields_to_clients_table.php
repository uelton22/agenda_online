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
        // Adicionar campos de autenticação
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
            if (!Schema::hasColumn('clients', 'remember_token')) {
                $table->string('remember_token', 100)->nullable()->after('password');
            }
            if (!Schema::hasColumn('clients', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('remember_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('clients', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
            if (Schema::hasColumn('clients', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }
};
