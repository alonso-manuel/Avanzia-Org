<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CampanaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_url_de_la_campana_muestra_la_campana_actual_con_su_grupo(): void
    {
        $actual = config('campanas.lista.'.config('campanas.actual'));

        // landing.avanzia.org enmascara esta URL: debe responder la página, no redirigir
        $this->get('/gracias-por-inscribirte/')->assertOk();

        $this->get(route('campana.gracias'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/campana/Gracias')
                ->where('campana.grupo_whatsapp', $actual['grupo_whatsapp'])
                ->has('campana.temario', 3)
                ->where('seo.indexar', false)
            );
    }

    public function test_los_textos_comunes_se_pueden_cambiar_por_campana(): void
    {
        config(['campanas.lista.ingenieria-pedagogica.textos' => ['titulo' => 'Título propio']]);

        $this->get(route('campana.gracias.curso', 'ingenieria-pedagogica'))
            ->assertInertia(fn (Assert $page) => $page
                ->where('campana.textos.titulo', 'Título propio')
                ->where('campana.textos.boton', config('campanas.textos.boton'))
            );
    }

    public function test_no_se_indexa_ni_aparece_en_el_sitemap(): void
    {
        $this->get(route('campana.gracias'))
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        $this->get('/sitemap.xml')->assertDontSee('gracias');
    }

    public function test_cada_campana_tiene_su_url_y_las_inexistentes_dan_404(): void
    {
        $this->get(route('campana.gracias.curso', 'ingenieria-pedagogica'))->assertOk();
        $this->get('/gracias/no-existe')->assertNotFound();
    }

    public function test_las_paginas_normales_si_se_indexan(): void
    {
        $this->get(route('home'))->assertDontSee('noindex', false);
    }
}
