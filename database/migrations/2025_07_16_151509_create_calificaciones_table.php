<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('curso_periodo_id');
            $table->unsignedBigInteger('profesor_id')->nullable();
            $table->unsignedBigInteger('carrera_id')->nullable();

            $table->decimal('primer_avance', 5, 2)->nullable();
            $table->decimal('segundo_avance', 5, 2)->nullable();
            $table->decimal('presentacion_final', 5, 2)->nullable();
            $table->decimal('promedio_avance', 5, 2)->nullable();  // NUEVA COLUMNA

            $table->decimal('oral_1', 5, 2)->nullable();
            $table->decimal('oral_2', 5, 2)->nullable();
            $table->decimal('oral_3', 5, 2)->nullable();
            $table->decimal('oral_4', 5, 2)->nullable();
            $table->decimal('oral_5', 5, 2)->nullable();

            $table->decimal('promedio', 5, 2)->nullable();
            $table->decimal('promedio_evaluacion_permanente', 5, 2)->nullable();
            $table->decimal('examen_final', 5, 2)->nullable();
            $table->decimal('promedio_final', 5, 2)->nullable();

            $table->timestamps();

            // Relaciones (si tienes las tablas relacionadas)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('curso_periodo_id')->references('id')->on('curso_periodo')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('carrera_id')->references('id')->on('carreras')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
