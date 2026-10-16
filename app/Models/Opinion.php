<?php

namespace App\Models;

use App\Enums\EstadoOpinion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    protected $table = 'opiniones';

    protected $fillable = [
        'nombre', 'pais', 'ciudad', 'institucion', 'curso', 'estrellas',
        'comentario', 'estado', 'ip', 'aprobada_en',
    ];

    protected function casts(): array
    {
        return [
            'estado' => EstadoOpinion::class,
            'estrellas' => 'integer',
            'aprobada_en' => 'datetime',
        ];
    }

    /** @param  Builder<self>  $query */
    public function scopeAprobadas(Builder $query): void
    {
        $query->where('estado', EstadoOpinion::Aprobada);
    }

    /** Campos que se muestran en el sitio (nunca la IP ni el estado). */
    public const CAMPOS_PUBLICOS = ['id', 'nombre', 'pais', 'ciudad', 'institucion', 'curso', 'estrellas', 'comentario'];

    /**
     * Total y promedio de los testimonios publicados.
     *
     * @return array{resenas: int, promedio: float}
     */
    public static function estadisticas(): array
    {
        $fila = static::aprobadas()->selectRaw('count(*) as total, avg(estrellas) as promedio')->toBase()->first();

        return [
            'resenas' => (int) $fila->total,
            'promedio' => round((float) $fila->promedio, 2),
        ];
    }
}
