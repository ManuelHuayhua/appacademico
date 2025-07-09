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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido_p')->after('name');
            $table->string('apellido_m')->after('apellido_p');
            $table->date('fecha_nacimiento')->nullable()->after('apellido_m');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
            $table->string('telefono')->nullable()->after('genero');
            $table->boolean('estado')->default(true)->after('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellido_p',
                'apellido_m',
                'fecha_nacimiento',
                'genero',
                'telefono',
                'estado',
            ]);
        });
    }
};
