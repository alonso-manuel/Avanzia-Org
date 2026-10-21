<?php

use App\Http\Controllers\Public\CampanaController;
use App\Http\Controllers\Public\InicioController;
use App\Http\Controllers\Public\InteraccionController;
use App\Http\Controllers\Public\OpinionController;
use App\Http\Controllers\Public\PaginaController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\SolicitudConvenioController;
use App\Http\Middleware\CompartirDatosPublicos;
use Illuminate\Support\Facades\Route;

// Zona pública (landing): toda página nueva va dentro de este grupo para recibir los datos del layout
Route::middleware(CompartirDatosPublicos::class)->group(function () {
    Route::get('/', InicioController::class)->name('home');
    Route::post('opiniones', [OpinionController::class, 'store'])
        ->middleware('throttle:5,10')
        ->name('opiniones.store');
    Route::post('cursos/{curso}/interaccion', [InteraccionController::class, 'store'])
        ->middleware('throttle:30,1')
        ->name('cursos.interaccion');
    Route::post('convenios/solicitud', [SolicitudConvenioController::class, 'store'])
        ->middleware('throttle:3,10')
        ->name('convenios.solicitud');

    // Agradecimiento de campañas (landing.avanzia.org enmascara /gracias-por-inscribirte). Ver config/campanas.php
    Route::get('gracias-por-inscribirte', [CampanaController::class, 'gracias'])->name('campana.gracias');
    Route::get('gracias/{campana}', [CampanaController::class, 'gracias'])
        ->where('campana', '[a-z0-9-]+')
        ->name('campana.gracias.curso');

    // Mismas rutas que el WordPress anterior (sin barra final)
    Route::controller(PaginaController::class)->group(function () {
        Route::get('quienes-somos', 'quienesSomos')->name('quienes-somos');
        Route::get('convenios', 'convenios')->name('convenios');
        Route::get('testimonios', 'testimonios')->name('testimonios');
        Route::get('validacionlegalcertificadoavanzia', 'validacion')->name('validacion');
        Route::get('libro-de-reclamaciones', 'libroReclamaciones')->name('libro-reclamaciones');
        Route::get('politica-de-privacidad', 'privacidad')->name('privacidad');
        Route::get('descargo-de-responsabilidad', 'descargo')->name('descargo');
        Route::get('terminos-y-condiciones', 'terminos')->name('terminos');
        Route::get('copyright', 'copyright')->name('copyright');
    });
});

Route::get('sitemap.xml', SitemapController::class)->name('sitemap');

// URLs del WordPress anterior (config/avanzia.php)
// Con Route::get y no Route::permanentRedirect: esta registra todos los métodos HTTP (incluido QUERY),
// que Wayfinder no sabe tipar y rompe la comprobación de TypeScript.
foreach (config('avanzia.redirecciones') as $antigua => $nueva) {
    Route::get($antigua, fn () => redirect($nueva, 301));
}

foreach (config('avanzia.eliminadas') as $eliminada) {
    Route::get($eliminada, fn () => abort(410));
}

// Sin zona autenticada por ahora (el panel de administración es el de Studio). Ver archivo/kit-admin/.
