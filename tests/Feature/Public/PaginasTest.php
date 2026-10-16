<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaginasTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string, string}> */
    public static function paginas(): array
    {
        return [
            'quiénes somos' => ['/quienes-somos', 'public/QuienesSomos'],
            'convenios' => ['/convenios', 'public/Convenios'],
            'testimonios' => ['/testimonios', 'public/Testimonios'],
            'validación' => ['/validacionlegalcertificadoavanzia', 'public/Validacion'],
            'libro de reclamaciones' => ['/libro-de-reclamaciones', 'public/LibroReclamaciones'],
            'privacidad' => ['/politica-de-privacidad', 'public/legal/Privacidad'],
            'términos' => ['/terminos-y-condiciones', 'public/legal/Terminos'],
            'descargo' => ['/descargo-de-responsabilidad', 'public/legal/Descargo'],
            'copyright' => ['/copyright', 'public/legal/Copyright'],
        ];
    }

    #[DataProvider('paginas')]
    public function test_la_pagina_conserva_su_url_y_recibe_seo_y_datos_del_layout(string $url, string $componente): void
    {
        $this->get($url)
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component($componente)
                ->has('seo', fn (Assert $seo) => $seo
                    ->whereType('title', 'string')
                    ->whereType('description', 'string')
                    ->where('url', url($url))
                    ->etc()
                )
                ->has('convenios')
            );
    }

    #[DataProvider('paginas')]
    public function test_la_url_antigua_con_barra_final_tambien_funciona(string $url): void
    {
        $this->get($url.'/')->assertOk();
    }

    public function test_el_sitemap_incluye_las_paginas_publicas(): void
    {
        $respuesta = $this->get('/sitemap.xml');

        foreach (self::paginas() as [$url]) {
            $respuesta->assertSee('<loc>'.url($url).'</loc>', false);
        }
    }
}
