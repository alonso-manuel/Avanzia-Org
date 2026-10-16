<?php

namespace Database\Factories;

use App\Enums\EstadoOpinion;
use App\Models\Opinion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Opinion>
 */
class OpinionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'pais' => 'pe',
            'ciudad' => 'Lima',
            'institucion' => null,
            'curso' => 'Avanzia STUDIO',
            'estrellas' => 5,
            'comentario' => fake()->sentence(15),
            'estado' => EstadoOpinion::Pendiente,
        ];
    }

    public function aprobada(): static
    {
        return $this->state([
            'estado' => EstadoOpinion::Aprobada,
            'aprobada_en' => now(),
        ]);
    }
}
