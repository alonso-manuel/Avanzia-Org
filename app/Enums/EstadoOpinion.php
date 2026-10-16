<?php

namespace App\Enums;

enum EstadoOpinion: string
{
    case Pendiente = 'pendiente';
    case Aprobada = 'aprobada';
    case Rechazada = 'rechazada';
}
