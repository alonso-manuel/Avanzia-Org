<?php

namespace Database\Seeders;

use App\Models\Convenio;
use Illuminate\Database\Seeder;

/**
 * Aliados reales de Avanzia (docs/CONTEXTO_AVANZIA.md, sección 5). Solo convenios verídicos:
 * las instituciones de la plantilla avanzia_convenios.html no lo eran y se retiraron (16/10/2026).
 */
class ConvenioSeeder extends Seeder
{
    public function run(): void
    {
        $convenios = [
            ['Google for Education', 'Aliado Tecnológico', '/images/convenios/google-for-education.webp', 'graduacion', 'azul'],
            ['OPAVAVE', 'Aliado Estratégico', '/images/convenios/opavave.webp', 'institucion', 'morado'],
        ];

        foreach ($convenios as $orden => [$nombre, $tipo, $logo, $icono, $color]) {
            Convenio::updateOrCreate(['nombre' => $nombre], [
                'tipo' => $tipo,
                'pais' => null,
                'logo' => $logo,
                'icono' => $icono,
                'color' => $color,
                'mostrar_en_pagina' => true,
                'orden' => $orden + 1,
            ]);
        }
    }
}
