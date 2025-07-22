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
    Schema::table('calificaciones', function (Blueprint $table) {
        $table->string('codigo_certificado')->nullable()->unique()->after('promedio_final'); // <-- ¡Aquí se aplica el UNIQUE!
        $table->boolean('pago_realizado')->default(false)->after('codigo_certificado');
        $table->boolean('califica_profesor')->default(false)->after('pago_realizado');
         $table->string('permiso')->default('denegado')->after('califica_profesor');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropColumn('codigo_certificado');
            $table->dropColumn('pago_realizado');
            $table->dropColumn('califica_profesor');
            $table->dropColumn('permiso');
        });
    }
};
