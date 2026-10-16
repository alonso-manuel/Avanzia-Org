<?php

/*
 * index.php para hosting donde la carpeta pública del dominio NO se puede apuntar a avanzia-landing/public.
 *
 * Estructura en el servidor:
 *   /home/fmqndrdnls/avanzia-landing/   ← proyecto completo (.env, vendor, app…), NO público
 *   /home/fmqndrdnls/avanzia.org/       ← solo el CONTENIDO de avanzia-landing/public (build, images,
 *                                          .htaccess, robots.txt…) y ESTE archivo renombrado a index.php
 *
 * Ver docs/DESPLIEGUE.md, "Opción B".
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Carpeta del proyecto, un nivel arriba de esta carpeta pública
$proyecto = dirname(__DIR__).'/avanzia-landing';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $proyecto.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $proyecto.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $proyecto.'/bootstrap/app.php';

// Los archivos públicos (build, imágenes, video) están en esta carpeta, no en avanzia-landing/public
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
