<?php

namespace Database\Seeders;

use App\Models\Convenio;
use Illuminate\Database\Seeder;

/**
 * Aliados y convenios (docs/CONTEXTO_AVANZIA.md, sección 5, y plantilla avanzia_convenios.html).
 * Los que tienen logo lo muestran; el resto usa el icono y el color indicados.
 * Google for Education y OPAVAVE solo aparecen como logos en el pie, no en la página /convenios.
 */
class ConvenioSeeder extends Seeder
{
    public function run(): void
    {
        $convenios = [
            ['Google for Education', 'Aliado Tecnológico', null, '/images/convenios/google-for-education.webp', 'graduacion', 'azul'],
            ['OPAVAVE', 'Aliado Estratégico', null, '/images/convenios/opavave.webp', 'institucion', 'morado'],
            ['Instituto de Educación Superior Público Ilave', 'Instituto Público', 'pe', null, 'institucion', 'azul'],
            ['Instituto de Educación Superior Privado Urusayhua', 'Instituto Privado', 'pe', null, 'graduacion', 'naranja'],
            ['Instituto de Educación Superior Privado American System', 'Instituto Privado', 'pe', null, 'laptop', 'rojo'],
            ['Universidad Nacional Autónoma de Alto Amazonas', 'Universidad Pública', 'pe', null, 'universidad', 'verde'],
            ['Confederación Universitaria de Docentes', 'Organización Magisterial', 'bo', null, 'personas', 'rojo'],
            ['Red Magisterial Mundial', 'Organización Internacional', null, null, 'mundo', 'celeste'],
            ['Cámara Mundial de Conferencistas y Oradores', 'Organización Global', null, null, 'microfono', 'ambar'],
            ['Universidad Líder Peruana', 'Universidad Privada', 'pe', null, 'libro', 'morado'],
        ];

        foreach ($convenios as $orden => [$nombre, $tipo, $pais, $logo, $icono, $color]) {
            Convenio::updateOrCreate(['nombre' => $nombre], [
                'tipo' => $tipo,
                'pais' => $pais,
                'logo' => $logo,
                'icono' => $icono,
                'color' => $color,
                'mostrar_en_pagina' => $logo === null,
                'orden' => $orden + 1,
            ]);
        }
    }
}
