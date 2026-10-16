<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Solicitud de alianza enviada desde /convenios. */
class SolicitudConvenio extends Model
{
    protected $table = 'solicitudes_convenio';

    protected $fillable = [
        'institucion', 'tipo_institucion', 'pais', 'sitio_web',
        'representante', 'cargo', 'correo', 'telefono',
        'interes', 'docentes', 'mensaje', 'estado', 'ip',
    ];

    protected function casts(): array
    {
        return [
            'docentes' => 'integer',
        ];
    }
}
