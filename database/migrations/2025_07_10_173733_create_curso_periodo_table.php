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
       Schema::create('curso_periodo', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('periodo_id');
            $table->string('seccion'); // Ej: A, B, C

            $table->date('fecha_apertura_matricula');
            $table->date('fecha_cierre_matricula');
            $table->date('fecha_inicio_clases');
            $table->date('fecha_fin_clases');
            $table->integer('vacantes');

            $table->timestamps();

            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');

            // Para evitar duplicados del mismo curso en el mismo periodo con misma sección
            $table->unique(['curso_id', 'periodo_id', 'seccion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_periodo');
    }
};
