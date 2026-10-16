<?php

namespace Tests\Feature\Public;

use App\Models\Curso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_las_urls_del_wordpress_anterior_redirigen_con_301(): void
    {
        $this->get('/cursos/')->assertStatus(301)->assertRedirect('/#cursos');
        $this->get('/contacto/')->assertStatus(301)->assertRedirect('/#convenios');
        $this->get('/product/deepseek-educativo/')->assertStatus(301)->assertRedirect('/#cursos');
        $this->get('/wp-sitemap.xml')->assertStatus(301)->assertRedirect('/sitemap.xml');
    }

    public function test_las_paginas_basura_de_wordpress_responden_410(): void
    {
        $this->get('/hello-world/')->assertStatus(410);
        $this->get('/elementor-hf/header/')->assertStatus(410);
    }

    public function test_el_sitemap_lista_la_portada(): void
    {
        Curso::factory()->create();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.route('home').'</loc>', false)
            ->assertSee('<lastmod>', false);
    }

    public function test_la_portada_escribe_json_ld_e_imagen_social_desde_el_servidor(): void
    {
        $curso = Curso::factory()->create();

        $this->get(route('home'))
            ->assertSee('<script type="application/ld+json">', false)
            ->assertSee('"@type":"EducationalOrganization"', false)
            ->assertSee('"name":"'.$curso->titulo.'"', false)
            ->assertSee('<meta property="og:image" content="'.url('/images/og-avanzia.jpg').'">', false)
            ->assertDontSee('noindex', false);
    }

    public function test_el_json_ld_no_permite_cerrar_la_etiqueta_script(): void
    {
        Curso::factory()->create(['titulo' => 'Curso </script><script>alert(1)</script>']);

        $this->get(route('home'))->assertDontSee('</script><script>alert(1)', false);
    }

    public function test_la_landing_no_expone_login_ni_panel(): void
    {
        // El único panel es el de Studio (misma base de datos); ver FortifyServiceProvider
        foreach (['/login', '/forgot-password', '/two-factor-challenge', '/dashboard', '/settings/profile'] as $url) {
            $this->get($url)->assertNotFound();
        }

        $this->post('/login', ['email' => 'admin@avanzia.org', 'password' => 'x'])->assertNotFound();
    }
}
