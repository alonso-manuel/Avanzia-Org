# Contexto del proyecto: avanzia.org (landing + instituto)

Este archivo resume el objetivo del proyecto, las decisiones ya tomadas y los límites del hosting.
Léelo antes de proponer cambios de arquitectura: varias decisiones responden a restricciones del hosting, no a preferencias.

---

## 1. Qué es Avanzia

**Avanzia América Latina** capacita a docentes de América Latina en el uso de inteligencia artificial y herramientas digitales para planificar, evaluar y crear materiales.

- Producto principal hoy: **cursos en vivo** (ciclos intensivos de 3 días, 100% online, con certificado).
- Nuevo producto: **Studio**, asistente docente con IA, lanzado el 16 de octubre de 2026.
- Próximo producto: **cursos grabados (asincrónicos)** dentro de un instituto en línea.
- También atienden **instituciones** (colegios y universidades) con planes especiales.
- Público: docentes de inicial, primaria, secundaria y superior. Llegan sobre todo por Facebook, Instagram y WhatsApp.
- Contacto principal y canal de venta: WhatsApp `+51 965 654 894` (`https://wa.me/51965654894`).
- País base: Perú (moneda PEN, zona horaria `America/Lima`).

## 2. Ecosistema de proyectos

| Dominio              | Qué es                                        | Proyecto                                                                            |
| -------------------- | --------------------------------------------- | ----------------------------------------------------------------------------------- |
| `avanzia.org`        | Landing pública y, más adelante, el instituto | **Este repositorio**                                                                |
| `studio.avanzia.org` | Studio (asistente con IA)                     | Proyecto Laravel 13 **separado** (`C:\Users\Alonso\Desktop\yape-verification-demo`) |
| `portal.avanzia.org` | Portal educativo actual (aula virtual)        | Externo, se mantiene por ahora                                                      |

- La decisión es **mantener Studio y este proyecto separados** (deploys y fallos independientes).
- El sitio actual de `avanzia.org` es WordPress + Elementor + WooCommerce y será reemplazado por este proyecto.
- Studio usa Blade (no Vue). Este proyecto usa Inertia + Vue porque el instituto será una aplicación interactiva.

## 3. Qué pidió el cliente para la landing

Referentes que dio el cliente:

- **Progressio** (`https://progressiolatam.com`): vive de cursos en vivo; muestra los cursos sincrónicos directamente en su web y deriva a los alumnos a dejar testimonios.
- **Konstruedu** (`https://konstruedu.com/es/`): vive de cursos asincrónicos, como un instituto web.

Avanzia quiere una **mezcla de ambos**. Prioridades, en este orden:

1. **Studio arriba de todo.** Un bloque tipo "Avanzia te ayuda a crear con IA", con una captura de la pantalla "¿qué quieres crear?" de Studio y un botón **"Pruébalo gratis"** que lleva a `studio.avanzia.org`.
2. **Cursos en vivo bien visibles**: hoy son el producto que más vende. Mostrar próximos ciclos.
3. **Cursos grabados en un menú aparte**, incluyendo un **curso gratuito de OpenAI** que sirve de gancho.
4. Testimonios / opiniones de alumnos.
5. Convenios / aliados.

Sobre el panel del alumno (para el instituto): al cliente le gusta el modelo de Progressio: al entrar a un curso se ven las sesiones 1, 2, 3…, algunas **bloqueadas con candado**, con los videos alojados en **Vimeo**.

Sobre cuentas: el cliente quiere que quien se registre con Google en Studio tenga **la misma cuenta** en la web. Ver la sección 8 (decisión pendiente).

## 4. Plantilla base de la landing

El diseño aprobado por el cliente está en **`docs/referencia/plantilla-landing-dafa.html`** (HTML estático con Tailwind por CDN y JavaScript simple). Es la referencia visual: se debe portar a componentes Vue respetando el diseño.

Secciones de la plantilla, en orden:

| Ancla          | Sección                                                                                                                   |
| -------------- | ------------------------------------------------------------------------------------------------------------------------- |
| `#inicio`      | Hero con titular animado tipo máquina de escribir                                                                         |
| `#nosotros`    | Tres beneficios ("Tu sesión, lista para el lunes", "Rúbricas claras, sin empezar de cero", "Tus materiales, tu criterio") |
| `#cursos`      | Catálogo de especialización (tarjetas generadas desde un arreglo JS)                                                      |
| —              | "Educación continua asincrónica" (cursos grabados)                                                                        |
| `#comentarios` | Opiniones de los cursos                                                                                                   |
| `#convenios`   | Convenios / aliados                                                                                                       |
| —              | Footer                                                                                                                    |
| —              | Modal de **temario** del curso                                                                                            |
| —              | Modal **"Tu experiencia"** (formulario para dejar una opinión)                                                            |

Cómo portarla:

- Tailwind por CDN → Tailwind 4 del proyecto (`resources/css/app.css`). Los colores y fuentes de marca de la plantilla van como tokens en `@theme`.
- Los cursos, temarios, opiniones y convenios están fijos en el JS de la plantilla → pasan a **base de datos** y llegan como props de Inertia.
- **Testimonios (decisión del 16/10/2026):** cualquiera puede publicar el suyo y **se publica al instante** (no hay panel para aprobar). Moderación automática: si contiene una palabra de `config('avanzia.opiniones.palabras_revision')` queda `pendiente`. Para retirar uno: estado `rechazada` en la tabla `opiniones`. Se puede volver a la aprobación manual con `AVANZIA_OPINIONES_AUTOMATICAS=false`.
- **Seguridad del texto libre** (`App\Support\TextoPlano` + `GuardarOpinionRequest`): se quitan caracteres de control e invisibles/de dirección; se **rechaza** HTML (`<script>`, `<img…>`, `</b>`, `<!--`) y enlaces/correos; nombre y ciudad solo admiten letras y signos de nombre; curso y país, solo valores de la lista; límites de longitud; duplicados (misma IP y texto en 24 h), límite por IP y campo trampa. Se muestra siempre como texto plano (`{{ }}`, nunca `v-html`). Mensajes de validación en `lang/es/validation.php`.
- Cada sección es un componente en `resources/js/components/public/`.
- El bloque de Studio (prioridad 1 de la sección 3) **no está en la plantilla** y hay que agregarlo.

## 5. Contenido del sitio actual (para migrar)

Catálogo actual (18 cursos):

| Categoría               | Cursos                                                                                                                                                                                                                              |
| ----------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Inteligencia artificial | Docente Innovador 1, Docente Innovador 2, Asistentes Educativos Automáticos con IA, Automatización Docente (AI Studio), IA Generativa Google, DeepSeek Educativo, Comenio IA, Ecosistemas Digitales, Presentaciones Interactivas IA |
| Diseño                  | Diseño con Canva, Diseño con Adobe Express                                                                                                                                                                                          |
| Metodología             | Gamificación Educativa, Storytelling Educativo                                                                                                                                                                                      |
| Productividad           | Herramientas Google, Ofimática Inteligente, Extensiones Chrome, Organización Digital                                                                                                                                                |
| Investigación           | Investigación Inteligente                                                                                                                                                                                                           |

**Catálogo real en carga** (`CursoSeeder`, lo único que va a producción): cada curso trae un **afiche cuadrado** (`public/images/cursos/{slug}.webp`, 800 px) y su **temario** (`{slug}-temario.webp`). La tarjeta muestra el afiche limpio, sin degradados ni etiquetas encima. Campos `gratuito` (etiqueta "Gratis", JSON-LD `isAccessibleForFree`) y `duracion` (texto, p. ej. "3 días", si no se mide en horas). Los cursos de ejemplo de la plantilla ya se eliminaron.
Cargados (6, todos de 3 días): Ingeniería Pedagógica con IA, Experto en Gemini Avanzado, IA Estratégica con Claude, Narrativas que Enseñan (Storytelling), Investigación Inteligente y Herramientas Digitales para la Gamificación. Los afiches se recortan **encima de la franja inferior y de los sellos** (Google/Meta), que quedarían cortados.

Datos publicados en algunos cursos: 120 horas, nivel avanzado, cantidad de estudiantes (+75 a +90). El cliente debe confirmar si aplican a todos.

Aliados actuales: **Google for Education** y **OPAVAVE**.

Redes: Facebook `avanzialatam`, Instagram `avanzialatam`.

### URLs del WordPress y SEO

El sitio actual no tiene plugin de SEO; su sitemap (`/wp-sitemap.xml`, octubre de 2026) tiene ~25 URLs, varias de prueba.
El mapa completo está en `config/avanzia.php`:

- **Redirigen con 301:** `/cursos/`, `/quienes-somos/`, `/contacto/`, `/product/deepseek-educativo/`, los dos artículos (`/domina-canva-2025-…`, `/transforma-la-educacion-…`), `/gracias-por-inscribirte/` y `/wp-sitemap.xml`.
- **Responden 410** (para que Google las retire): `/hello-world/`, `/elementor-*`, `/wishsuite/`, `/checkout-page/`, categorías `uncategorized`, etc.
- **Páginas propias con la misma ruta** (`PaginaController`): `/quienes-somos`, `/convenios`, `/testimonios` (todos los publicados, 12 por página; la portada enlaza con "Mostrar todos"), `/validacionlegalcertificadoavanzia`, `/libro-de-reclamaciones`, `/politica-de-privacidad`, `/terminos-y-condiciones`, `/descargo-de-responsabilidad` y `/copyright`. Los textos legales se copiaron tal cual del sitio anterior.
- Domicilio fiscal (de los términos): Av. Apurímac 431, Cusco, Cusco, Perú. Se muestra en el Libro de reclamaciones.

Servicios externos que usan estas páginas (no viven en este proyecto):

- **Validador de certificados:** aplicación de Google Apps Script de la cuenta de Avanzia, embebida en un iframe (`Validacion.vue`). Es pública y permite embeberse.
- **Libro de reclamaciones:** formulario de Google Forms embebido (`LibroReclamaciones.vue`). La versión embebida responde 401 sin sesión de Google, aunque la normal abre bien; por eso la página ofrece "Abrir en una pestaña nueva". Revisar la configuración del formulario. Su texto indica un plazo de respuesta de 30 días calendario: confirmar con el cliente que esté vigente.

Laravel ignora la barra final y el `.htaccess` la redirige, así que la URL canónica siempre va **sin** barra final.

SEO técnico ya implementado: metadatos y `og:*` desde el servidor, imagen para compartir por defecto (`public/images/og-avanzia.jpg`), JSON-LD de la organización en todas las páginas públicas (`Seo::organizacion()`), `sitemap.xml` (`SitemapController`: agregar ahí cada página pública nueva), `robots.txt` y `noindex` en las páginas sin prop `seo` (login, panel).

**Al publicar:** verificar el dominio en Google Search Console, enviar `https://avanzia.org/sitemap.xml` y revisar los errores de cobertura las semanas siguientes.
Pendiente: una página por curso (`/cursos/{slug}`) con su propio `seo` y JSON-LD `Course`, cuando el cliente confirme el catálogo.

## 6. Stack y estructura

- **Laravel 13** (PHP ≥ 8.4: las dependencias de Symfony 8 lo exigen), **Inertia 3**, **Vue 3 + TypeScript**, **Tailwind 4**, Vite (`vite-plus`).
- **Sin login ni panel por ahora.** El único panel de administración es el de Studio (sección 8). Fortify está instalado pero con `Fortify::ignoreRoutes()`: no hay `/login`, `/dashboard` ni `/settings`. Las páginas, layouts, componentes y tests del kit se guardaron en `archivo/kit-admin/` (no se compila ni se prueba), con instrucciones para restaurarlo.
- **Wayfinder** genera las rutas tipadas para el frontend (`resources/js/actions`, `resources/js/routes`).
- Panel de administración: **también con Inertia + Vue**. No usar Filament ni Livewire, para no mezclar dos formas de trabajar.
- Modelos de dominio en español (igual que Studio): `Curso`, `Opinion`, `Convenio`, `Modulo`, `Sesion`, `Inscripcion`…

Estructura por zonas: cada zona tiene sus páginas, controladores y layout, para que el instituto se agregue sin tocar la landing.

```
app/Http/Controllers/
  Public/       → landing, catálogo, validación de certificados
  Admin/        → panel de administración (futuro; hoy solo existe el de Studio)
  Instituto/    → panel del alumno (futuro)
app/Support/Seo.php → metadatos de páginas públicas

resources/js/
  pages/public/        → páginas públicas (layout: PublicLayout)
  pages/admin/         → panel (pendiente)
  pages/instituto/     → alumno (futuro)
  components/public/   → secciones de la landing, SeoHead
  layouts/public/      → PublicLayout (header, bloque de contacto/convenios/libro de reclamaciones, footer, botón WhatsApp)
```

El layout de cada página se asigna por prefijo en `resources/js/app.ts` (`public/` → `PublicLayout`, `auth/` → `AuthLayout`, etc.).

**Carrito de cursos** (`resources/js/lib/public/carrito.ts` + `CarritoPanel.vue` en el layout): "Lo quiero" agrega el curso y abre el panel lateral; al cerrarlo queda un botón flotante con contador sobre el de WhatsApp. Se guarda en el `localStorage` del visitante (se mantiene al navegar y recargar). Mientras no haya pasarela, "Enviar pedido por WhatsApp" arma un mensaje con la lista de cursos. Cuando haya precios y pagos, el carrito pasa al servidor.

**Contador de interesados por curso** (tabla `interacciones_curso`, `InteraccionController`): "Ver temario" y "Lo quiero" registran en segundo plano una interacción por visitante, curso y tipo (cookie anónima `avanzia_visitante`, guardada como hash). La tarjeta muestra "N interesados" (visitantes distintos) desde `AVANZIA_UMBRAL_INTERESADOS` (10 en producción; 1 en local para probar). El número = `cursos.alumnos` (docentes de ciclos anteriores, cifra real informada por Avanzia: 120 por curso al 16/10/2026) + visitantes distintos. Los números siempre son reales: no sembrar interacciones falsas en `interacciones_curso`; si cambia la cifra histórica, actualizar `alumnos`. Mencionar la cookie en la política de privacidad.

**Convenios** (`/convenios`, plantilla `avanzia_convenios.html`): solo aliados verídicos (hoy Google for Education y OPAVAVE; las instituciones de la plantilla no lo eran y se retiraron). Tarjetas desde la tabla `convenios` (tipo, país, logo o icono/color) y el formulario "Intención formal de convenio", que guarda en `solicitudes_convenio` (estado `nueva`) y **encola** un correo a `avanzia@avanzia.org` (`NuevaSolicitudConvenio`, responder al correo contesta al representante). **En producción hay que configurar SMTP** (`MAIL_*` en `.env`); en local va al log. "Establecer Alianza" de la portada abre el formulario (`/convenios?solicitar=1`).

**Política de privacidad** reescrita (16/10/2026) según lo que hace el sitio: formularios (opiniones, convenios), IP, cookies (`avanzia_landing_session`, `XSRF-TOKEN`, `avanzia_visitante`), carrito en `localStorage`, Google y WhatsApp. Si se agrega analítica, pagos u otro formulario, actualizarla. Conviene revisión legal y verificar la inscripción del banco de datos ante la ANPD.

**Páginas de campaña ("¡Falta un paso!")** (`config/campanas.php`, `CampanaController`, `pages/public/campana/Gracias.vue`): tras inscribirse desde una campaña de Facebook, el docente ve un botón gigante para unirse al grupo de WhatsApp del curso y el temario. `landing.avanzia.org` es una **redirección enmascarada de Spaceship** (marco) hacia `avanzia.org/gracias-por-inscribirte`, que muestra la campaña `actual`; `/gracias/{clave}` muestra cualquier otra. Van **sin layout** (sin menú ni pie), con `noindex` y fuera del sitemap. Campaña nueva = copiar un bloque en la config (grupo, color, capacitador, temario). **Todos los textos** también están en la config (`textos`, comunes; cada campaña puede cambiar los suyos), así que el dueño los edita desde el Administrador de archivos de cPanel sin compilar. Solo cambiar el **diseño** (`Gracias.vue`) requiere `npm run build` y subir `build/`. Venían del tema Astra Child del WordPress (`page-gracias-ingenieria.php`).

Toda ruta pública nueva va dentro del grupo con el middleware `CompartirDatosPublicos` en `routes/web.php`: comparte los convenios que muestra el layout en todas las páginas.

## 7. Límites del hosting (MUY IMPORTANTE)

Producción: **Spaceship Web Hosting – plan Essential** (hosting compartido con cPanel).

- 1 CPU, **1 GB de RAM**, 20 GB NVMe, límite de **300 000 archivos**.
- **SSH restringido (jailed)**. No hay procesos permanentes (ni Node, ni `queue:work` continuo, ni websockets).
- PHP seleccionable en cPanel (**usar 8.4 o superior**: con 8.3 el sitio no arranca). MariaDB/MySQL.
- Se planea migrar a **VPS** más adelante (probablemente cuando arranque el instituto).

Reglas que se derivan de esto:

1. **Sin SSR por ahora.** `INERTIA_SSR_ENABLED=false` en `.env`. Pero **todos los componentes deben ser compatibles con SSR**: no usar `window`, `document` ni `localStorage` fuera de `onMounted` o de guardas `typeof window !== 'undefined'`. Así, al pasar a VPS, activar SSR es solo configuración.
2. **SEO y vistas previas desde el servidor.** Cada página pública recibe la prop `seo` con `App\Support\Seo::make(title, description, image)`. `resources/views/app.blade.php` escribe `description`, `og:*` y `canonical` en el HTML inicial (WhatsApp/Facebook no ejecutan JS). En Vue se usa `<SeoHead :seo="seo" />` para mantenerlos al navegar.
3. **Compilar en local.** `npm run build` en la máquina de desarrollo y subir `public/build`. El hosting no compila. **Nunca subir `node_modules`** (límite de archivos).
4. **Colas sin worker permanente.** `QUEUE_CONNECTION=database` y un cron de cPanel cada minuto:
   `php artisan schedule:run`, con una tarea programada que ejecute `queue:work --stop-when-empty --max-time=50`. Correos y tareas pesadas siempre en cola, nunca dentro de la petición.
5. **Nada de tiempo real.** Sin Reverb/Pusher/websockets. Si algo necesita "actualizarse solo", usar polling de Inertia (`usePoll`) con intervalos razonables.
6. **Peticiones cortas.** Nada que mantenga un proceso PHP ocupado muchos segundos (llamadas largas a APIs externas, generación de PDFs pesados en la petición, etc.): mandarlo a la cola. Con 1 GB caben ~15-20 procesos PHP simultáneos.
7. **Videos fuera del hosting.** Los videos de cursos van en **Vimeo**; aquí solo se guarda el ID y se controla el acceso.
8. **Imágenes optimizadas** (WebP, tamaños razonables) y cacheadas. Sesión y caché en base de datos (`SESSION_DRIVER=database`, `CACHE_STORE=database`).
9. **Base de datos:** SQLite en local, **MySQL/MariaDB en producción**. Escribir migraciones compatibles con ambos.

### Base de datos compartida con Studio

La landing usa **la misma base de datos que Studio** (`avanzia_tienda` en local). Reglas para no pisarse:

- **Migraciones separadas:** la landing registra las suyas en `landing_migrations` (Studio usa `migrations`). Así un `migrate:rollback` de un proyecto nunca deshace las del otro.
- **Tablas de Studio** que la landing también declara (`users`, `password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` y las columnas 2FA): sus migraciones solo crean lo que falta (para el SQLite de los tests) y su `down()` **no borra nada**. Las administra Studio.
- **Tablas propias de la landing:** `cursos`, `opiniones`, `convenios`, `interacciones_curso`, `solicitudes_convenio`. No modificar tablas de Studio desde este proyecto.
- **Separación en las tablas compartidas:** cola `landing` (Studio usa `default`), prefijo de caché `avanzia-landing-cache-` y cookie de sesión `avanzia_landing_session`. Están fijados en `config/`, no dependen del `.env`.
- **No crear usuarios desde la landing** (seeders, factories en local, etc.): la tabla `users` son los administradores de Studio y cualquier cuenta creada aquí entraría a su panel.
- Antes de migrar en producción: **respaldo de la base** (es la de Studio).

Al migrar a VPS: activar SSR (`INERTIA_SSR_ENABLED=true`, `npm run build:ssr`, proceso `php artisan inertia:start-ssr` con supervisor), worker de colas permanente y, si hace falta, Redis.

## 8. Futuro: el instituto (no construir todavía)

Se construirá en **este mismo proyecto**. Alcance previsto:

- Panel del alumno: mis cursos, sesiones numeradas, **sesiones bloqueadas** hasta cumplir condición, progreso.
- Estructura: `Curso → Modulo → Sesion`, con `Inscripcion` por alumno.
- Videos en Vimeo (solo visibles para inscritos).
- Certificados en PDF con **código de validación** público (reemplaza la página de validación actual).
- **Pagos**: se reutilizará la pasarela ya hecha en Studio (Yape, Plin, transferencia y tarjeta con Openpay; 7 países; tipo de cambio). Se copia y se adapta para vender cursos en vez de planes.
- **Roles** en el panel para delegar tareas sin dar control total.
- El panel de administración de este proyecto es **independiente** del de Studio.

**Decisión tomada: cuenta única con Studio (base de usuarios compartida).** Como ambos proyectos usan la misma base de datos, los alumnos del instituto serán los mismos `avia_users` de Studio, y viceversa: quien se registra en uno ya tiene cuenta en el otro.

**Paneles de administración separados.** Por ahora solo existe el panel de Studio; el de la landing/instituto se construirá aparte. Cuando se haga, decidir si sus administradores son los mismos `users` de Studio (con permisos por proyecto) o una tabla propia. Mientras tanto, la landing no tiene login ni panel (desactivados; ver `archivo/kit-admin/LEEME.md`). Las opiniones pendientes, los cursos y los convenios se gestionan por ahora directamente en la base de datos (o desde el panel de Studio, si se agrega allí).

## 9. Información pendiente del cliente

- Fechas de los próximos ciclos en vivo, horarios y precios.
- Medios de pago para cursos.
- Testimonios reales (texto, nombre, colegio, país, foto si hay permiso).
- Logos oficiales de aliados y permiso de uso.
- Lista definitiva de cursos en vivo y de cursos grabados.
- Captura de Studio para el bloque principal.
- Detalle del curso gratuito de OpenAI.

## 10. Comandos y notas de entorno

```bash
composer dev          # servidor + vite + colas en local
npm run build         # compilar para subir a producción
php artisan test      # tests (PHPUnit)
composer lint         # Pint
npm run check:fix     # formato y lint del frontend
npm run types:check   # vue-tsc
```

- Tests en `tests/Feature/<Zona>/`. Toda página pública nueva debe tener un test que verifique el componente Inertia y la prop `seo`.
- En esta máquina Windows, `composer lint` (Pint) puede fallar con un error `phar://…yape-verification-demo…` por la caché de opcache en CLI. Solución: ejecutar con `opcache.enable_cli=0` (por ejemplo, `PHP_INI_SCAN_DIR` apuntando a una carpeta con un `.ini` que lo desactive).
- `npm run types:check` reporta errores en `resources/js/actions/Illuminate/Routing/RedirectController.ts` (código generado por Wayfinder, método HTTP `query`). Es un desajuste entre versiones del kit, no del código del proyecto.
