<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla compartida con Studio: solo se crea si no existe (p. ej., en el SQLite de los tests).
     */
    public function up(): void
    {
        if (! Schema::hasTable('cache')) {
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->bigInteger('expiration')->index();
            });
        }

        if (! Schema::hasTable('cache_locks')) {
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->bigInteger('expiration')->index();
            });
        }
    }

    /**
     * No borra nada: en producción estas tablas las comparte Studio (misma base de datos)
     * y deshacer la landing no debe tocarlas. Ver docs/CONTEXTO_AVANZIA.md (base compartida).
     */
    public function down(): void
    {
        //
    }
};
