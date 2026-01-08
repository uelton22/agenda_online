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
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 0 = Domingo, 1 = Segunda, ..., 6 = Sábado
            $table->time('start_time'); // Hora de início (ex: 08:00)
            $table->time('end_time'); // Hora de término (ex: 18:00)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Índices para busca
            $table->index(['service_id', 'day_of_week']);
            $table->index('day_of_week');

            // Constraint para garantir unicidade do dia por serviço
            $table->unique(['service_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_schedules');
    }
};

