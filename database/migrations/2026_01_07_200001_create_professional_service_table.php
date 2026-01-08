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
        Schema::create('professional_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable(); // Preço específico do profissional (null = usa preço padrão do serviço)
            $table->integer('duration')->nullable(); // Duração específica (null = usa duração padrão do serviço)
            $table->json('available_slots')->nullable(); // Horários específicos do profissional para este serviço
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Índice único para evitar duplicatas
            $table->unique(['professional_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_service');
    }
};

