# avanzia.org

Sitio web de **Avanzia América Latina**: landing pública y, más adelante, su instituto en línea.

## Sobre Avanzia

Avanzia América Latina capacita a docentes de inicial, primaria, secundaria y superior en el uso de inteligencia artificial y herramientas digitales para planificar, evaluar y crear materiales. Su objetivo es que el docente deje atrás el trabajo mecánico y la carga documental, y recupere tiempo para lo que lo llevó a enseñar.

Su oferta se organiza en cuatro líneas:

- **Cursos en vivo.** Ciclos intensivos de 3 días, 100 % online y con certificado, en inteligencia artificial, diseño, metodología, productividad e investigación. Hoy son el producto principal.
- **Avanzia Flex (cursos grabados).** Educación continua asincrónica: grabaciones, materiales descargables y evaluaciones automatizadas para estudiar al propio ritmo, sin horarios fijos. Incluirá un curso gratuito de introducción.
- **Avanzia STUDIO.** Asistente docente con IA ([studio.avanzia.org](https://studio.avanzia.org)) que genera unidades didácticas, sesiones de aprendizaje y rúbricas en minutos, y que puede trabajar sobre los propios PDFs o documentos del docente.
- **Instituciones.** Planes para colegios y universidades que quieren capacitar a toda su plana docente.

Avanzia tiene su base en Perú y atiende a docentes de toda América Latina, que llegan sobre todo por Facebook, Instagram y WhatsApp. Cuenta con el respaldo de aliados como Google for Education y OPAVAVE.

## Qué contiene este repositorio

| Zona                    | Estado        | Descripción                                                                            |
| ----------------------- | ------------- | -------------------------------------------------------------------------------------- |
| Landing pública         | En desarrollo | Portada con Studio, catálogo de cursos en vivo, cursos grabados, opiniones y convenios |
| Panel de administración | Pendiente     | Gestión de cursos, opiniones y convenios (Inertia + Vue)                               |
| Instituto               | Futuro        | Panel del alumno con sesiones, videos en Vimeo, certificados y pagos                   |

Studio es un proyecto **separado**, con su propio repositorio y despliegue.

## Stack

- **Laravel 13** (PHP ≥ 8.3) con **Fortify** para la autenticación
- **Inertia 3** + **Vue 3** + **TypeScript**
- **Tailwind CSS 4** y Vite (`vite-plus`)
- **Wayfinder** para las rutas tipadas en el frontend
- SQLite en local, MySQL/MariaDB en producción

## Puesta en marcha local

Requisitos: PHP 8.3 o superior, Composer y Node 20 o superior.

```bash
composer setup          # instala dependencias, crea .env, migra y compila
php artisan db:seed     # cursos y convenios; en local también opiniones de ejemplo
composer dev            # servidor, Vite y colas
```

El sitio queda en `http://localhost:8000`.

## Comandos

| Comando               | Para qué                            |
| --------------------- | ----------------------------------- |
| `composer dev`        | Entorno de desarrollo completo      |
| `npm run build`       | Compilar los assets para producción |
| `php artisan test`    | Tests (PHPUnit)                     |
| `composer lint`       | Formato del código PHP (Pint)       |
| `npm run check:fix`   | Formato y lint del frontend         |
| `npm run types:check` | Verificación de tipos (vue-tsc)     |

## Estructura

```
app/
  Enums/                       Categoría y modalidad de curso, estado de opinión
  Http/Controllers/Public/     Landing y formulario de opiniones
  Models/                      Curso, Opinion, Convenio
  Support/Seo.php              Metadatos de las páginas públicas
resources/js/
  pages/public/                Páginas públicas
  components/public/           Secciones de la landing
  layouts/public/              Encabezado, pie y botón de WhatsApp
  lib/public/                  Datos de contacto y efecto de aparición al hacer scroll
docs/
  CONTEXTO_AVANZIA.md          Contexto completo del proyecto (leer antes de trabajar)
  referencia/                  Plantilla de diseño aprobada
```

## Contenido de la landing

- Los **cursos, opiniones y convenios** se guardan en la base de datos y llegan a la portada como props de Inertia.
- Las **opiniones** que se envían desde el sitio se guardan como _pendientes_ y solo se publican al aprobarlas. Mientras no exista el panel de administración, se aprueban desde `php artisan tinker`.
- No hay **registro público** de usuarios por ahora.

## Producción

El sitio corre en un hosting compartido (1 GB de RAM, sin procesos permanentes), lo que impone algunas reglas:

- Los assets se compilan en local (`npm run build`) y se sube `public/build`. Nunca se sube `node_modules`.
- Sin SSR ni websockets. Los componentes Vue deben seguir siendo compatibles con SSR para activarlo más adelante en un VPS.
- Las colas se procesan con el cron de cPanel ejecutando `php artisan schedule:run` cada minuto.
- Los videos de los cursos se alojan en Vimeo, no en el servidor.

El detalle de estas decisiones está en [`docs/CONTEXTO_AVANZIA.md`](docs/CONTEXTO_AVANZIA.md).

## Contacto

- Web: [avanzia.org](https://avanzia.org)
- WhatsApp: [+51 965 654 894](https://wa.me/51965654894)
- Correo: avanzia@avanzia.org
