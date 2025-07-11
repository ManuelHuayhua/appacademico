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
    Schema::create('horarios', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('curso_periodo_id'); // Nuevo campo
        $table->unsignedBigInteger('profesor_id');      // Profesor asignado

        $table->tinyInteger('dia_semana');              // 1 = lunes, ..., 7 = domingo
        $table->time('hora_inicio');
        $table->time('hora_fin');

        $table->timestamps();

        $table->foreign('curso_periodo_id')
              ->references('id')->on('curso_periodo')
              ->onDelete('cascade');

        $table->foreign('profesor_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
