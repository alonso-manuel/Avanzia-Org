<?php

namespace Tests\Feature\Public;

use App\Http\Controllers\Public\InteraccionController;
use App\Models\Curso;
use App\Models\InteraccionCurso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InteraccionTest extends TestCase
{
    use RefreshDatabase;

    private const VISITANTE = '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d';

    private function interactuar(Curso $curso, string $tipo, string $visitante = self::VISITANTE)
    {
        // withCredentials: las peticiones JSON de prueba no envían cookies si no se pide
        return $this->withCredentials()
            ->withCookie(InteraccionController::COOKIE, $visitante)
            ->postJson(route('cursos.interaccion', $curso), ['tipo' => $tipo]);
    }

    public function test_registra_la_interaccion_y_devuelve_los_interesados(): void
    {
        $curso = Curso::factory()->create();

        $this->interactuar($curso, 'temario')
            ->assertOk()
            ->assertJson(['interesados' => 1])
            ->assertCookie(InteraccionController::COOKIE);

        $this->assertSame(1, InteraccionCurso::count());
    }

    public function test_un_visitante_cuenta_una_sola_vez_por_curso_y_tipo(): void
    {
        $curso = Curso::factory()->create();

        $this->interactuar($curso, 'temario');
        $this->interactuar($curso, 'temario');
        $this->interactuar($curso, 'carrito')->assertJson(['interesados' => 1]);

        // Dos registros (uno por tipo), pero una sola persona interesada
        $this->assertSame(2, InteraccionCurso::count());
    }

    public function test_visitantes_distintos_suman_interesados(): void
    {
        $curso = Curso::factory()->create();

        $this->interactuar($curso, 'temario');
        $this->interactuar($curso, 'carrito', '1c6f6f2e-5f0b-4f2a-9a7e-2f1d3c4b5a6e')
            ->assertJson(['interesados' => 2]);
    }

    public function test_no_guarda_el_identificador_del_visitante_en_claro(): void
    {
        $curso = Curso::factory()->create();

        $this->interactuar($curso, 'temario');

        $this->assertSame(hash('sha256', self::VISITANTE), InteraccionCurso::sole()->visitante);
    }

    public function test_rechaza_tipos_invalidos_y_cursos_no_publicados(): void
    {
        $curso = Curso::factory()->create();
        $oculto = Curso::factory()->create(['publicado' => false]);

        $this->interactuar($curso, 'like')->assertUnprocessable();
        $this->interactuar($oculto, 'temario')->assertNotFound();
        $this->assertSame(0, InteraccionCurso::count());
    }

    public function test_la_portada_envia_los_interesados_y_el_umbral(): void
    {
        config(['avanzia.umbral_interesados' => 10]);
        $curso = Curso::factory()->create();

        $this->interactuar($curso, 'temario');
        $this->interactuar($curso, 'carrito', '1c6f6f2e-5f0b-4f2a-9a7e-2f1d3c4b5a6e');

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
                ->where('cursos.0.interesados', 2)
                ->where('umbralInteresados', 10)
            );
    }
}
