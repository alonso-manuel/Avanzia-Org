<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_convenio', function (Blueprint $table) {
            $table->id();
            // Institución
            $table->string('institucion', 160);
            $table->string('tipo_institucion', 20);
            $table->string('pais', 80);
            $table->string('sitio_web')->nullable();
            // Representante
            $table->string('representante', 120);
            $table->string('cargo', 120);
            $table->string('correo', 160);
            $table->string('telefono', 40);
            // Solicitud
            $table->string('interes', 20);
            $table->unsignedInteger('docentes');
            $table->text('mensaje')->nullable();
            // nueva | contactada | descartada (se gestiona por ahora desde la base o el panel de Studio)
            $table->string('estado', 20)->default('nueva');
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index(['estado', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_convenio');
    }
};
