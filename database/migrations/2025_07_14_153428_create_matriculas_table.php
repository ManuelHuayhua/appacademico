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
       Schema::create('matriculas', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id'); // Alumno
        $table->unsignedBigInteger('curso_periodo_id'); // Curso en periodo

        $table->date('fecha_matricula')->default(now());
        $table->string('estado')->default('activo');

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('curso_periodo_id')->references('id')->on('curso_periodo')->onDelete('cascade');

        $table->unique(['user_id', 'curso_periodo_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
