<?php

namespace Tests\Feature\Public;

use App\Mail\NuevaSolicitudConvenio;
use App\Models\SolicitudConvenio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SolicitudConvenioTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    private function datos(array $cambios = []): array
    {
        return [
            'institucion' => 'IEP San Miguel',
            'tipo_institucion' => 'colegio',
            'pais' => 'Perú',
            'sitio_web' => 'www.sanmiguel.edu.pe',
            'representante' => 'Rosa Quispe',
            'cargo' => 'Directora Académica',
            'correo' => 'rosa@sanmiguel.edu.pe',
            'telefono' => '+51 999 111 222',
            'interes' => 'mixto',
            'docentes' => 45,
            'mensaje' => 'Queremos capacitar a toda la plana docente.',
            'acepta' => true,
            ...$cambios,
        ];
    }

    public function test_la_pagina_de_convenios_envia_las_opciones_del_formulario(): void
    {
        $this->get(route('convenios'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/Convenios')
                ->has('opciones.tiposInstitucion')
                ->has('opciones.intereses')
                ->has('opciones.paises')
            );
    }

    public function test_guarda_la_solicitud_y_encola_el_aviso_por_correo(): void
    {
        Mail::fake();

        $this->from(route('convenios'))
            ->post(route('convenios.solicitud'), $this->datos())
            ->assertRedirect(route('convenios'));

        $solicitud = SolicitudConvenio::sole();
        $this->assertSame('IEP San Miguel', $solicitud->institucion);
        $this->assertSame('nueva', $solicitud->estado);

        // En cola (hosting sin worker permanente): nunca dentro de la petición
        Mail::assertQueued(NuevaSolicitudConvenio::class, fn ($mail) => $mail->hasTo(config('avanzia.email_convenios'))
            && $mail->hasReplyTo('rosa@sanmiguel.edu.pe'));
    }

    public function test_acepta_un_pais_escrito_a_mano(): void
    {
        Mail::fake();

        $this->post(route('convenios.solicitud'), $this->datos(['pais' => 'Guatemala']));

        $this->assertSame('Guatemala', SolicitudConvenio::sole()->pais);
    }

    public function test_valida_los_campos_obligatorios(): void
    {
        Mail::fake();

        $this->post(route('convenios.solicitud'), $this->datos([
            'institucion' => '',
            'tipo_institucion' => 'banco',
            'correo' => 'no-es-correo',
            'docentes' => 0,
            'acepta' => false,
        ]))->assertSessionHasErrors(['institucion', 'tipo_institucion', 'correo', 'docentes', 'acepta']);

        $this->assertSame(0, SolicitudConvenio::count());
        Mail::assertNothingQueued();
    }

    public function test_ignora_los_envios_de_bots(): void
    {
        Mail::fake();

        $this->post(route('convenios.solicitud'), $this->datos(['empresa_web' => 'spam']))->assertRedirect();

        $this->assertSame(0, SolicitudConvenio::count());
        Mail::assertNothingQueued();
    }

    public function test_el_correo_de_aviso_se_puede_renderizar(): void
    {
        $solicitud = SolicitudConvenio::create([...$this->datos(), 'estado' => 'nueva']);

        (new NuevaSolicitudConvenio($solicitud))
            ->assertSeeInHtml('IEP San Miguel')
            ->assertSeeInHtml('Convenio Mixto Integral')
            ->assertSeeInHtml('Rosa Quispe');
    }
}
