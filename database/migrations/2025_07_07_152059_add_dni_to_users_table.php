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
            $table->string('dni', 20)->nullable()
                  ->unique()
                  ->after('id');

            $table->boolean('usuario')
                  ->default(false)
                  ->after('dni');

            $table->boolean('admin')
                  ->default(false)
                  ->after('usuario');

            $table->boolean('profesor')
                  ->default(false)
                  ->after('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dni', 'usuario', 'admin', 'profesor']);
        });
    }
};
