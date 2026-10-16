<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interacciones_curso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            // temario | carrito (App\Enums\TipoInteraccion)
            $table->string('tipo', 20);
            // Hash del identificador anónimo del navegador (cookie), sin datos personales
            $table->char('visitante', 64);
            $table->timestamp('created_at')->useCurrent();

            // Una interacción por visitante, curso y tipo
            $table->unique(['curso_id', 'tipo', 'visitante']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interacciones_curso');
    }
};
