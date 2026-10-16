# Kit de administración desactivado

Páginas, layouts, componentes, controladores y tests del *starter kit* de Laravel (login, recuperación de contraseña, 2FA, dashboard y ajustes de perfil). Se retiraron de la landing el 16/10/2026 porque, por ahora, **el único panel de administración es el de Studio** (ambos proyectos comparten la base de datos y la tabla `users` son los administradores de Studio).

Esta carpeta no se compila, no se prueba ni se lintea. Se conserva como punto de partida para el panel propio de la landing/instituto.

## Para restaurarlo

1. Mover cada archivo de vuelta a su misma ruta en la raíz del proyecto (`archivo/kit-admin/resources/js/...` → `resources/js/...`, etc.).
2. Quitar `Fortify::ignoreRoutes()` de `app/Providers/FortifyServiceProvider.php`.
3. Volver a registrar las rutas: el grupo `auth` con `dashboard` y `require __DIR__.'/settings.php';` en `routes/web.php`.
4. Asignar los layouts por prefijo en `resources/js/app.ts` (`auth/` → `AuthLayout`, `settings/` → `[AppLayout, SettingsLayout]`).
5. `php artisan wayfinder:generate --with-form`, `npm run types:check` y `php artisan test`.

Antes, decidir si los administradores de la landing son los mismos `users` de Studio o una tabla propia (ver `docs/CONTEXTO_AVANZIA.md`, sección 8).
