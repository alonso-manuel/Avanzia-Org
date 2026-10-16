<?php

namespace Tests\Feature\Public;

use App\Models\Opinion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class TestimoniosTest extends TestCase
{
    use RefreshDatabase;

    public function test_muestra_solo_los_testimonios_publicados_sin_datos_internos(): void
    {
        Opinion::factory()->aprobada()->create(['nombre' => 'Publicada', 'ip' => '10.0.0.1']);
        Opinion::factory()->create(['nombre' => 'Pendiente']);

        $this->get(route('testimonios'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/Testimonios')
                ->has('opiniones.data', 1)
                ->where('opiniones.data.0.nombre', 'Publicada')
                ->missing('opiniones.data.0.ip')
                ->missing('opiniones.data.0.estado')
                ->where('estadisticas.resenas', 1)
                ->has('cursosOpinion')
                ->has('paises')
            );
    }

    public function test_pagina_de_doce_en_doce_del_mas_reciente_al_mas_antiguo(): void
    {
        foreach (range(1, 14) as $n) {
            Opinion::factory()->aprobada()->create([
                'nombre' => "Docente {$n}",
                'aprobada_en' => now()->subMinutes(100 - $n),
            ]);
        }

        $this->get(route('testimonios'))
            ->assertInertia(fn (Assert $page) => $page
                ->has('opiniones.data', 12)
                ->where('opiniones.data.0.nombre', 'Docente 14')
                ->where('opiniones.last_page', 2)
            );

        $this->get(route('testimonios', ['page' => 2]))
            ->assertInertia(fn (Assert $page) => $page
                ->has('opiniones.data', 2)
                ->where('opiniones.data.1.nombre', 'Docente 1')
                ->where('seo.title', fn (string $titulo) => str_contains($titulo, 'página 2'))
            );
    }
}
