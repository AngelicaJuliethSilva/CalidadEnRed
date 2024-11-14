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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();  // El ID autoincremental
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');  // Clave foránea para el usuario que evalúa
            $table->foreignId('evaluated_id')->constrained('users')->onDelete('cascade');  // Clave foránea para el usuario que se evalúa
            $table->date('fecha');  // Fecha de la evaluación
            $table->integer('resultado');  // Resultado de la evaluación (puedes cambiar el tipo si es necesario)
            $table->text('comentarios')->nullable();  // Comentarios adicionales
            $table->timestamps();  // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
