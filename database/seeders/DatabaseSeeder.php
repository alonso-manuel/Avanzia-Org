<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Solo datos de la landing. No crear usuarios: la tabla users es de Studio
     * (base de datos compartida) y cualquier cuenta creada aquí entraría a su panel.
     */
    public function run(): void
    {
        $this->call([CursoSeeder::class, ConvenioSeeder::class]);

        // Opiniones ficticias solo para ver el diseño en desarrollo
        if (app()->isLocal()) {
            $this->call(OpinionDemoSeeder::class);
        }
    }
}
