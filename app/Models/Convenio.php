<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = ['nombre', 'tipo', 'pais', 'logo', 'icono', 'color', 'url', 'publicado', 'mostrar_en_pagina', 'orden'];

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
            'mostrar_en_pagina' => 'boolean',
        ];
    }

    /** @param  Builder<self>  $query */
    public function scopePublicados(Builder $query): void
    {
        $query->where('publicado', true)->orderBy('orden')->orderBy('id');
    }

    /** Campos que reciben el layout y la página de convenios. */
    public const CAMPOS_PUBLICOS = ['id', 'nombre', 'tipo', 'pais', 'logo', 'icono', 'color', 'url', 'mostrar_en_pagina'];
}
