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
          Schema::create('dictado_profesor', function (Blueprint $table) {
            $table->id();

            // Relación con el usuario (profesor)
            $table->unsignedBigInteger('profesor_id');
            $table->foreign('profesor_id')->references('id')->on('users')->onDelete('cascade');

            // Estado del dictado (bien / mal)
            $table->enum('estado_dictado', ['bien', 'mal']);

            // Fecha y hora de la evaluación
            $table->date('fecha_calificacion');
            $table->time('hora_calificacion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictado_profesor');
    }
};
