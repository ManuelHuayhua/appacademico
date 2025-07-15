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
    Schema::create('asistencias', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');           // Alumno
        $table->unsignedBigInteger('curso_periodo_id');  // Curso + periodo

        $table->date('fecha');                           // Fecha de clase
        $table->boolean('asistio')->nullable();                    // true = asistió, false = faltó

        $table->timestamps();

        // Llaves foráneas
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('curso_periodo_id')->references('id')->on('curso_periodo')->onDelete('cascade');

        // Evitar registros duplicados del mismo alumno, en el mismo curso, en el mismo día
        $table->unique(['user_id', 'curso_periodo_id', 'fecha']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
