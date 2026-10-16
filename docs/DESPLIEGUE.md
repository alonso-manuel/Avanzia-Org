# Despliegue en producción (Spaceship · cPanel)

Guía para subir la landing al hosting compartido. El hosting no compila ni tiene Node: todo se prepara en local y se sube un .zip.

> **Regla de oro:** el proyecto va **fuera** de cualquier carpeta pública. Solo su subcarpeta `public/` se expone a internet. Si el proyecto entero queda dentro de una carpeta pública (por ejemplo `avanzia.org/landing/`), cualquiera podría descargar `.env` con las claves de la base de datos y del correo.

Usuario del hosting: `/home/fmqndrdnls`. Estructura final:

```
/home/fmqndrdnls/
├── avanzia-landing/          ← el proyecto (NO público)
│   ├── app/ config/ vendor/ … .env
│   └── public/               ← lo único que ve internet
└── avanzia.org/              ← WordPress actual (se deja intacto como respaldo)
```

## 1. Preparar el paquete (en local)

```powershell
powershell -ExecutionPolicy Bypass -File scripts\empaquetar-produccion.ps1
```

Genera `avanzia-landing-produccion.zip` (~17 MB): frontend compilado, dependencias sin las de desarrollo, sin `.env`, sin `public/hot` ni tests.

## 2. Preparar el hosting (una sola vez)

1. **PHP**: cPanel → *Select PHP Version* → 8.3 o 8.4, con `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `zip`.
2. **Respaldo de la base de datos de Studio** (es la misma): cPanel → *Backup* o *phpMyAdmin → Exportar*. Guardarlo fuera del servidor.
3. **Subir y descomprimir**: *File Manager* → en `/home/fmqndrdnls` crear la carpeta `avanzia-landing`, subir el .zip ahí y *Extract*. Borrar el .zip después.
4. **`.env`**: copiar `.env.production.example` como `.env` y completar base de datos (la de Studio), contraseña del correo y, mientras se prueba, `APP_URL` con la dirección del sitio de prueba.
5. **Permisos**: `storage/` y `bootstrap/cache/` deben poder escribirse (755 en carpetas suele bastar).

## 3a. Sin Terminal (situación actual)

1. **Clave de la aplicación**: en local, `php artisan key:generate --show` (no modifica tu `.env` local). Copiar el resultado (`base64:…`) en `APP_KEY` del `.env` del servidor.
2. **Tablas**: generar el SQL con las tablas de la landing (cursos y convenios con datos; testimonios, interacciones y solicitudes vacías; y `landing_migrations` con todas las migraciones marcadas como hechas) e importarlo en **phpMyAdmin → base de producción → Importar**. No toca tablas de Studio.
   - Se genera desde la base local con `mysqldump` (ver cómo en el historial del proyecto; el archivo queda en `despliegue/`, que no se sube al repositorio).
   - **Importarlo una sola vez**: incluye `DROP TABLE IF EXISTS` de las tablas de la landing, así que reimportarlo borraría los testimonios y solicitudes que ya existan en producción.
3. **Cachés**: opcionales. Sin `config:cache` el sitio funciona igual.

## 3b. Con Terminal (cPanel → *Terminal*)

```bash
cd ~/avanzia-landing
php artisan key:generate --force
php artisan migrate --force          # crea solo las tablas de la landing; no toca las de Studio
php artisan db:seed --force          # cursos reales y convenios (sin datos de ejemplo)
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

`migrate` usa la tabla `landing_migrations` (Studio usa `migrations`) y las migraciones de tablas compartidas se saltan si ya existen. Ver `docs/CONTEXTO_AVANZIA.md`, "Base de datos compartida".

## 4. Cron (cPanel → *Cron Jobs*, cada minuto)

```
* * * * * cd /home/fmqndrdnls/avanzia-landing && php artisan schedule:run >> /dev/null 2>&1
```

Procesa la cola `landing` (correos de solicitudes de convenio). Sin esto, las solicitudes se guardan pero el aviso no sale.

## 5. Sitio de prueba

Usar un **subdominio** (p. ej. `prueba.avanzia.org`), no una subcarpeta como `avanzia.org/landing/`: el sitio usa rutas desde la raíz (`/convenios`, `/images/…`, `/opiniones`) que en una subcarpeta irían al WordPress, y además el proyecto quedaría dentro de una carpeta pública.

cPanel → *Domains* → *Create A New Domain* → `prueba.avanzia.org`, desmarcar "Share document root" y poner como **raíz del documento**:

```
/home/fmqndrdnls/avanzia-landing/public
```

Probar: portada, catálogo y temarios, carrito y WhatsApp, testimonios (publicar uno), convenios (enviar una solicitud y verificar que llegue el correo), validación de certificados, libro de reclamaciones, páginas legales, `/sitemap.xml`, redirecciones (`/cursos/` → portada) y la vista en celular.

## 6. Lanzamiento en avanzia.org (también sirve si se lanza sin sitio de prueba)

Antes: respaldo del WordPress (archivos de `avanzia.org/` + su base de datos) y de la base de Studio. En `.env`: `APP_URL=https://avanzia.org`.

**Nunca** subir el proyecto completo dentro de `avanzia.org/`: es la carpeta pública y quedaría expuesto `avanzia.org/.env`.

### Opción A (preferida): cambiar la raíz del documento

cPanel → *Domains* → `avanzia.org` → *Manage* → **Document Root** = `/home/fmqndrdnls/avanzia-landing/public`.
El WordPress queda intacto en `avanzia.org/`. **Volver atrás**: devolver la raíz a `/home/fmqndrdnls/avanzia.org`.

### Opción B: si la raíz del documento no se puede cambiar

1. Vaciar `avanzia.org/` (el WordPress ya está respaldado).
2. Copiar ahí **solo el contenido** de `avanzia-landing/public/`: `build/`, `images/`, `videos/`, `.htaccess`, `robots.txt`, `favicon.ico`, `icono-192.png`, `apple-touch-icon.png`. En el File Manager, activar *Settings → Show Hidden Files* para ver `.htaccess`.
3. Reemplazar su `index.php` por `scripts/index-carpeta-publica.php` (renombrado a `index.php`): carga el proyecto desde `../avanzia-landing` y le indica que lo público está en `avanzia.org/`.
4. **En cada actualización** volver a copiar `public/build/` (y las imágenes nuevas) a `avanzia.org/`.

**Volver atrás**: vaciar `avanzia.org/` y descomprimir ahí el respaldo del WordPress.

### Después de lanzar

- Probar la lista del punto 5 en `https://avanzia.org`.
- Google Search Console: verificar el dominio y enviar `https://avanzia.org/sitemap.xml`.

## Actualizaciones posteriores

Generar el .zip de nuevo, subirlo, descomprimir **encima** (sin borrar `.env` ni `storage/`) y ejecutar:

```bash
php artisan migrate --force
php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```
