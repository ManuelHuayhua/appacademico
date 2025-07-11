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
       Schema::table('curso_periodo', function (Blueprint $table) {
        $table->enum('turno', ['mañana', 'tarde', 'noche'])->after('seccion');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('curso_periodo', function (Blueprint $table) {
        $table->dropColumn('turno');
    });
    }
};
