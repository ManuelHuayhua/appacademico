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
       Schema::create('carreras', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->unsignedBigInteger('facultad_id');
    $table->timestamps();

    $table->foreign('facultad_id')->references('id')->on('facultades')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
