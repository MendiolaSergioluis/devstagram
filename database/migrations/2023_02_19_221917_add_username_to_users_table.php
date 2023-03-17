<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Se ejecuta al correr las migraciones
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username'); // Añade nueva columna
        });
    }

    /**
     * Se ejecuta al correr un rollback a las migraciones
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username')->unique(); // Elimina la columna en caso de rollback
        });
    }
};
