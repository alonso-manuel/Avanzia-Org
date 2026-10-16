<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            // Docentes que ya tomaron el curso en ciclos anteriores (cifra real informada por Avanzia).
            // Es la base del contador de interesados: se suma a los visitantes que interactúan.
            $table->unsignedInteger('alumnos')->nullable()->after('gratuito');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('alumnos');
        });
    }
};
