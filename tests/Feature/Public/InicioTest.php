<?php

namespace Tests\Feature\Public;

use App\Enums\ModalidadCurso;
use App\Models\Convenio;
use App\Models\Curso;
use App\Models\Opinion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_portada_renderiza_la_pagina_publica_con_seo(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/Inicio')
                ->has('seo', fn (Assert $seo) => $seo
                    ->whereType('title', 'string')
                    ->whereType('description', 'string')
                    ->where('url', route('home'))
                    ->etc()
                )
            );
    }

    public function test_los_metadatos_se_escriben_en_el_html_desde_el_servidor(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('<meta property="og:title"', false)
            ->assertSee('<meta name="description"', false);
    }

    public function test_muestra_solo_cursos_en_vivo_publicados(): void
    {
        $visible = Curso::factory()->create();
        Curso::factory()->create(['publicado' => false]);
        Curso::factory()->create(['modalidad' => ModalidadCurso::Grabado]);

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->has('cursos', 1)
                ->where('cursos.0.titulo', $visible->titulo)
            );
    }

    public function test_envia_si_el_curso_es_gratuito_y_su_duracion(): void
    {
        Curso::factory()->create(['gratuito' => true, 'horas' => null, 'duracion' => '3 días']);

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->where('cursos.0.gratuito', true)
                ->where('cursos.0.duracion', '3 días')
            )
            ->assertSee('"isAccessibleForFree":true', false);
    }

    public function test_los_interesados_parten_de_los_alumnos_de_ciclos_anteriores(): void
    {
        $curso = Curso::factory()->create(['alumnos' => 120]);

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page->where('cursos.0.interesados', 120));

        // Un visitante nuevo suma uno sobre la base
        $this->withCredentials()
            ->withCookie('avanzia_visitante', '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d')
            ->postJson(route('cursos.interaccion', $curso), ['tipo' => 'temario'])
            ->assertJson(['interesados' => 121]);
    }

    public function test_comparte_los_convenios_publicados_para_el_layout(): void
    {
        Convenio::create(['nombre' => 'Google for Education']);
        Convenio::create(['nombre' => 'Aliado oculto', 'publicado' => false]);

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->has('convenios', 1)
                ->where('convenios.0.nombre', 'Google for Education')
            );
    }

    public function test_muestra_solo_opiniones_aprobadas_y_sus_estadisticas(): void
    {
        Opinion::factory()->aprobada()->create(['estrellas' => 5]);
        Opinion::factory()->aprobada()->create(['estrellas' => 4]);
        Opinion::factory()->create();

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->has('opiniones', 2)
                ->where('estadisticas.resenas', 2)
                ->where('estadisticas.promedio', 4.5)
            );
    }
}
