<?php

namespace Database\Factories;

use App\Enums\CategoriaCurso;
use App\Enums\ModalidadCurso;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Curso>
 */
class CursoFactory extends Factory
{
    public function definition(): array
    {
        $titulo = fake()->unique()->sentence(3);

        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'categoria' => fake()->randomElement(CategoriaCurso::cases()),
            'modalidad' => ModalidadCurso::EnVivo,
            'descripcion' => fake()->sentence(12),
            'horas' => fake()->randomElement([30, 40, 60]),
            'color' => 'naranja',
            'publicado' => true,
        ];
    }
}
