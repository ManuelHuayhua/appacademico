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
       Schema::table('asistencias', function (Blueprint $table) {
            $table->string('url_material')->nullable()->after('asistio');
            $table->string('url_grabada')->nullable()->after('url_material');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn(['url_material', 'url_grabada']);
        });
    }
};
