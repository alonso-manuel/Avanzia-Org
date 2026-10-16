<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Las categorías de la plantilla (pedagogia, gestion, herramientas) pasan a las del catálogo real.
 * Solo afecta a cursos que aún las usen (en la práctica, los de ejemplo en local).
 */
return new class extends Migration
{
    private const CAMBIOS = [
        'pedagogia' => 'metodologia',
        'gestion' => 'metodologia',
        'herramientas' => 'productividad',
    ];

    public function up(): void
    {
        foreach (self::CAMBIOS as $antes => $despues) {
            DB::table('cursos')->where('categoria', $antes)->update(['categoria' => $despues]);
        }
    }

    public function down(): void
    {
        // No reversible con exactitud (dos categorías se unieron en "metodologia")
    }
};
