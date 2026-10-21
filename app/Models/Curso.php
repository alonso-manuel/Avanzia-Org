<?php

namespace App\Models;

use App\Enums\CategoriaCurso;
use App\Enums\ModalidadCurso;
use Database\Factories\CursoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property CategoriaCurso $categoria
 * @property ModalidadCurso $modalidad
 * @property-read int|null $interesados Solo si se cargó conInteresados()
 */
class Curso extends Model
{
    /** @use HasFactory<CursoFactory> */
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'titulo', 'slug', 'categoria', 'modalidad', 'descripcion', 'horas', 'duracion', 'gratuito', 'alumnos',
        'imagen', 'color', 'temario_imagen', 'publicado', 'orden',
    ];

    protected function casts(): array
    {
        return [
            'categoria' => CategoriaCurso::class,
            'modalidad' => ModalidadCurso::class,
            'publicado' => 'boolean',
            'gratuito' => 'boolean',
        ];
    }

    /** @param  Builder<self>  $query */
    public function scopePublicados(Builder $query): void
    {
        $query->where('publicado', true)->orderBy('orden')->orderBy('id');
    }

    /** @return HasMany<InteraccionCurso, $this> */
    public function interacciones(): HasMany
    {
        return $this->hasMany(InteraccionCurso::class);
    }

    /**
     * Agrega `interesados`: visitantes distintos que vieron el temario o agregaron el curso al carrito.
     *
     * @param  Builder<self>  $query
     */
    public function scopeConInteresados(Builder $query): void
    {
        $query->withCount([
            'interacciones as interesados' => fn (Builder $q) => $q->select(DB::raw('count(distinct visitante)')),
        ]);
    }

    /**
     * Interesados que se muestran: alumnos de ciclos anteriores (cifra real informada por Avanzia)
     * más los visitantes distintos que interactuaron. Requiere haber cargado conInteresados().
     */
    public function totalInteresados(): int
    {
        return (int) $this->interesados + (int) $this->alumnos;
    }

    /** Recalcula los visitantes distintos de este curso (tras registrar una interacción). */
    public function contarInteresados(): int
    {
        return $this->interacciones()->distinct()->count('visitante');
    }
}
