<?php

namespace App\Models;

use App\Enums\TipoInteraccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InteraccionCurso extends Model
{
    protected $table = 'interacciones_curso';

    public const UPDATED_AT = null;

    protected $fillable = ['curso_id', 'tipo', 'visitante'];

    protected function casts(): array
    {
        return [
            'tipo' => TipoInteraccion::class,
        ];
    }

    /** @return BelongsTo<Curso, $this> */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}
