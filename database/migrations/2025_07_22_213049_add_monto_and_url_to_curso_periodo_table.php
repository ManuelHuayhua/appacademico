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
            $table->decimal('monto_total', 8, 2)->nullable()->after('vacantes');
            $table->string('url_clase_virtual')->nullable()->after('monto_total');
        });
    }

    public function down(): void
    {
        Schema::table('curso_periodo', function (Blueprint $table) {
            $table->dropColumn('url_clase_virtual');
            $table->dropColumn('monto_total');
        });
    }
};
