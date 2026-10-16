<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opiniones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('pais', 2);
            $table->string('ciudad', 80);
            $table->string('institucion', 120)->nullable();
            $table->string('curso', 150);
            $table->unsignedTinyInteger('estrellas');
            $table->text('comentario');
            $table->string('estado', 20)->default('pendiente');
            $table->string('ip', 45)->nullable();
            $table->timestamp('aprobada_en')->nullable();
            $table->timestamps();

            $table->index(['estado', 'aprobada_en']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opiniones');
    }
};
