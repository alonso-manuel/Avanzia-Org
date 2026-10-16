<?php

namespace App\Enums;

/** Categorías del catálogo real de Avanzia (docs/CONTEXTO_AVANZIA.md, sección 5). */
enum CategoriaCurso: string
{
    case InteligenciaArtificial = 'ia';
    case Diseno = 'diseno';
    case Metodologia = 'metodologia';
    case Productividad = 'productividad';
    case Investigacion = 'investigacion';

    public function nombre(): string
    {
        return match ($this) {
            self::InteligenciaArtificial => 'Inteligencia Artificial',
            self::Diseno => 'Diseño',
            self::Metodologia => 'Metodología',
            self::Productividad => 'Productividad',
            self::Investigacion => 'Investigación',
        };
    }
}
