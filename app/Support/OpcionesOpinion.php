<?php

namespace App\Support;

use App\Enums\ModalidadCurso;
use App\Models\Curso;

/** Opciones del formulario de testimonios: también se validan en el servidor. */
class OpcionesOpinion
{
    public const STUDIO = 'Avanzia STUDIO (Asistente IA)';

    public const OTRO = 'Otro';

    /** @return list<string> */
    public static function cursos(): array
    {
        return [
            self::STUDIO,
            ...Curso::publicados()->where('modalidad', ModalidadCurso::EnVivo)->get()->map(fn (Curso $curso) => $curso->titulo)->all(),
            self::OTRO,
        ];
    }
}
