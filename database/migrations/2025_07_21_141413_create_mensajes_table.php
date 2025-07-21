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
            Schema::create('mensajes', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('remitente_id');
        $table->unsignedBigInteger('destinatario_id')->nullable();
        $table->unsignedBigInteger('curso_periodo_id')->nullable();

        $table->string('titulo');
        $table->text('contenido');

        $table->date('fecha_inicio'); // Desde cuándo se puede ver
        $table->date('fecha_fin');    // Hasta cuándo se puede ver

        $table->boolean('leido')->default(false);

        $table->timestamps();

        $table->foreign('remitente_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('destinatario_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('curso_periodo_id')->references('id')->on('curso_periodo')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
