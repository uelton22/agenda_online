<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Note: In SQLite, the user_id column should already be nullable in the original migration.
     * For MySQL/MariaDB, you may need to modify the column manually if needed.
     */
    public function up(): void
    {
        // SQLite não suporta ALTER TABLE MODIFY
        // Para MySQL, execute manualmente se necessário:
        // ALTER TABLE appointments MODIFY user_id BIGINT UNSIGNED NULL
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não reverter
    }
};
