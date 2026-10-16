<?php

namespace App\Support;

/** Opciones del formulario de solicitud de convenio (docs/referencia: avanzia_convenios.html). */
class OpcionesConvenio
{
    public const TIPOS_INSTITUCION = [
        'colegio' => 'Colegio / Escuela',
        'instituto' => 'Instituto Superior',
        'universidad' => 'Universidad',
        'ong' => 'ONG / Fundación',
        'otro' => 'Otro',
    ];

    public const INTERESES = [
        'licencias' => 'Licencias Avanzia STUDIO',
        'capacitacion' => 'Capacitación Docente (Cursos)',
        'mixto' => 'Convenio Mixto Integral',
    ];

    /** "Otro" permite escribir el país. */
    public const PAISES = ['Perú', 'México', 'Colombia', 'Ecuador', 'Bolivia', 'Chile', 'Argentina', 'Paraguay'];
}
