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
    Schema::create('retiros', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // alumno
        $table->unsignedBigInteger('curso_periodo_id');
        $table->unsignedBigInteger('periodo_id');
        $table->unsignedBigInteger('matricula_id')->nullable(); // opcional si deseas guardar la ID original
        $table->text('motivo')->nullable(); // opcional
        $table->timestamp('fecha_retiro')->useCurrent();
        $table->timestamps();

        // Claves foráneas
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('curso_periodo_id')->references('id')->on('curso_periodo')->onDelete('cascade');
        $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiros');
    }
};
