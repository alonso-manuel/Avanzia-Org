<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->string('categoria', 30);
            $table->string('modalidad', 20)->default('en_vivo');
            $table->text('descripcion');
            $table->unsignedSmallInteger('horas')->nullable();
            $table->string('imagen')->nullable();
            // Clave de color del degradado de la tarjeta (ver CatalogoCursos.vue)
            $table->string('color', 20)->default('naranja');
            $table->string('temario_imagen')->nullable();
            $table->boolean('publicado')->default(true);
            $table->unsignedSmallInteger('orden')->default(0);
            $table->timestamps();

            $table->index(['publicado', 'modalidad', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
