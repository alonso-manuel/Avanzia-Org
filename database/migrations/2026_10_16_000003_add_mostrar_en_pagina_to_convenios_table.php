<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            // false = solo aparece como logo en el pie (p. ej., aliados como Google for Education)
            $table->boolean('mostrar_en_pagina')->default(true)->after('publicado');
        });
    }

    public function down(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            $table->dropColumn('mostrar_en_pagina');
        });
    }
};
