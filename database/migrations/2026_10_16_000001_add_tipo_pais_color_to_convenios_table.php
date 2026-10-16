<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            // Ej.: "Instituto Público", "Universidad Privada", "Organización Internacional"
            $table->string('tipo', 60)->nullable()->after('nombre');
            // Código ISO del país (pe, bo…); null = internacional
            $table->string('pais', 2)->nullable()->after('tipo');
            // Clave de color de la tarjeta (ver ConvenioTarjeta.vue)
            $table->string('color', 20)->default('morado')->after('icono');
        });
    }

    public function down(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'pais', 'color']);
        });
    }
};
