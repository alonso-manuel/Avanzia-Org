<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->boolean('gratuito')->default(false)->after('horas');
            // Texto libre cuando la duración no se mide en horas (p. ej. "3 días")
            $table->string('duracion', 40)->nullable()->after('horas');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['gratuito', 'duracion']);
        });
    }
};
