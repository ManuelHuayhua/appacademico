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
       Schema::create('calificaciones_profesor', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('calificacion_id');
    $table->unsignedBigInteger('profesor_id'); // Nuevo campo

    $table->tinyInteger('pregunta_1');
    $table->tinyInteger('pregunta_2');
    $table->tinyInteger('pregunta_3');
    $table->tinyInteger('pregunta_4');
    $table->tinyInteger('pregunta_5');
    $table->text('comentario')->nullable();

    $table->timestamps();

    $table->foreign('calificacion_id')->references('id')->on('calificaciones')->onDelete('cascade');
    $table->foreign('profesor_id')->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones_profesor');
    }
};
