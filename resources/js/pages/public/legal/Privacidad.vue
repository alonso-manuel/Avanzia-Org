<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PaginaLegal from '@/components/public/PaginaLegal.vue';
import { DOMICILIO, EMAIL, RUC, RUTAS_LEGALES } from '@/lib/public/contacto';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();
</script>

<!--
    Redactada en octubre de 2026 a partir de lo que hace este sitio (formularios, cookies, carrito,
    servicios embebidos). Si cambia algo de eso, actualizar este texto. Conviene revisión de asesoría legal.
-->
<template>
    <PaginaLegal :seo="seo" titulo="Política de Privacidad">
        <p>
            En Avanzia América Latina la privacidad de quienes visitan nuestro
            sitio es importante. Esta política explica qué datos personales
            recopilamos en <strong>avanzia.org</strong>, para qué los usamos y
            cómo puedes ejercer tus derechos, conforme a la Ley N.° 29733, Ley
            de Protección de Datos Personales del Perú, y su reglamento.
        </p>
        <p><em>Última actualización: 16 de octubre de 2026.</em></p>

        <h2>1. Responsable del tratamiento</h2>
        <p>
            <strong>Avanzia América Latina S.A.C.</strong>, con RUC N.°
            {{ RUC }} y domicilio fiscal en {{ DOMICILIO }}. Para cualquier
            consulta sobre tus datos puedes escribirnos a
            <a :href="`mailto:${EMAIL}`">{{ EMAIL }}</a
            >.
        </p>

        <h2>2. Qué datos recopilamos y para qué</h2>
        <p>
            Solo recopilamos los datos que tú nos envías a través de los
            formularios del sitio y la información técnica mínima necesaria para
            que funcione:
        </p>
        <ul>
            <li>
                <strong>Opiniones sobre nuestros cursos.</strong> Nombre, país,
                ciudad, institución (opcional), curso, calificación y
                comentario. Los usamos para publicar tu opinión en el sitio,
                únicamente si nos autorizas expresamente al enviarla. Se publica
                al instante, salvo que un filtro automático la deje en revisión;
                podemos retirar las que incumplan las normas del sitio.
            </li>
            <li>
                <strong>Solicitudes de convenio institucional.</strong> Datos de
                la institución (nombre, tipo, país y sitio web) y de su
                representante (nombre, cargo, correo y teléfono), además del
                interés, el número aproximado de docentes y tu mensaje. Los
                usamos para evaluar la solicitud y contactarte.
            </li>
            <li>
                <strong>Dirección IP</strong> desde la que se envía cada
                formulario, para prevenir envíos automatizados y abusos.
            </li>
            <li>
                <strong>Registros técnicos del servidor</strong> (dirección IP,
                tipo de navegador, fecha y hora de la visita y páginas
                consultadas), que se usan para mantener el sitio funcionando y
                seguro.
            </li>
        </ul>
        <p>
            No vendemos, alquilamos ni cedemos tus datos personales a terceros.
            Solo acceden a ellos los proveedores que nos prestan servicios
            (alojamiento del sitio y correo electrónico) para los fines
            indicados, o las autoridades cuando la ley lo exija.
        </p>

        <h2>3. Carrito de cursos y pedidos por WhatsApp</h2>
        <p>
            Los cursos que agregas al carrito se guardan
            <strong>solo en tu navegador</strong> (almacenamiento local) para
            que no los pierdas al navegar o volver más tarde; no los recibimos
            hasta que tú decides enviarlos. Al pulsar «Enviar pedido por
            WhatsApp» se abre WhatsApp con un mensaje que contiene la lista de
            cursos, y la conversación se rige por las condiciones y la política
            de privacidad de WhatsApp (Meta).
        </p>

        <h2>4. Cookies</h2>
        <p>
            Usamos únicamente cookies técnicas y una cookie anónima de
            estadística. <strong>No usamos cookies publicitarias</strong> ni de
            seguimiento de terceros.
        </p>
        <ul>
            <li>
                <strong>avanzia_landing_session</strong> y
                <strong>XSRF-TOKEN</strong>: necesarias para el funcionamiento y
                la seguridad de los formularios. Se eliminan al poco tiempo de
                cerrar tu visita.
            </li>
            <li>
                <strong>avanzia_visitante</strong>: identificador anónimo y
                aleatorio que dura un año. Nos permite contar cuántas personas
                distintas se interesan por cada curso (al ver su temario o
                agregarlo al carrito), sin contarte dos veces. En nuestra base
                de datos solo guardamos una versión cifrada (hash) de ese
                identificador; no contiene ni se vincula con tu nombre, correo u
                otros datos personales.
            </li>
        </ul>
        <p>
            Puedes eliminar o bloquear las cookies desde la configuración de tu
            navegador. Si bloqueas las técnicas, es posible que los formularios
            no funcionen correctamente.
        </p>

        <h2>5. Servicios de terceros integrados</h2>
        <p>
            Algunas funciones del sitio se prestan mediante servicios externos.
            Al usarlos, el proveedor recibe tu dirección IP y los datos que
            ingreses, y se rige por su propia política de privacidad:
        </p>
        <ul>
            <li>
                <strong>Google</strong>: el validador de certificados (Google
                Apps Script) y el formulario del
                <Link :href="RUTAS_LEGALES.libroReclamaciones"
                    >Libro de Reclamaciones</Link
                >
                (Google Forms). Consulta la
                <a
                    href="https://policies.google.com/privacy"
                    target="_blank"
                    rel="noopener"
                    >política de privacidad de Google</a
                >.
            </li>
            <li>
                <strong>WhatsApp (Meta)</strong>: cuando decides escribirnos o
                enviar tu pedido por ese medio.
            </li>
            <li>
                <strong>Proveedores de imágenes</strong>: algunas imágenes y
                banderas del sitio se cargan desde servicios externos, que
                reciben tu dirección IP al mostrarlas.
            </li>
        </ul>
        <p>
            Estos proveedores pueden almacenar la información en servidores
            ubicados fuera del Perú.
        </p>

        <h2>6. Conservación de los datos</h2>
        <p>
            Conservamos tus datos durante el tiempo necesario para cumplir la
            finalidad para la que los enviaste (por ejemplo, mientras tu opinión
            esté publicada o mientras se evalúa la solicitud de convenio), o
            hasta que solicites su eliminación, salvo que una obligación legal
            exija conservarlos por más tiempo.
        </p>

        <h2>7. Tus derechos</h2>
        <p>
            Puedes ejercer en cualquier momento tus derechos de
            <strong>acceso, rectificación, cancelación y oposición</strong>
            sobre tus datos personales, así como revocar tu autorización (por
            ejemplo, para que retiremos tu opinión publicada). Escríbenos a
            <a :href="`mailto:${EMAIL}`">{{ EMAIL }}</a> indicando tu nombre, el
            derecho que deseas ejercer y un medio de contacto; podremos
            solicitarte un documento que acredite tu identidad.
        </p>
        <p>
            Si consideras que no hemos atendido tu solicitud, puedes presentar
            un reclamo ante la Autoridad Nacional de Protección de Datos
            Personales del Ministerio de Justicia y Derechos Humanos del Perú.
        </p>

        <h2>8. Seguridad</h2>
        <p>
            Aplicamos medidas técnicas y organizativas razonables para proteger
            tus datos frente a accesos no autorizados, pérdida o alteración,
            como conexiones cifradas (HTTPS) y acceso restringido a la
            información.
        </p>

        <h2>9. Cambios en esta política</h2>
        <p>
            Podemos actualizar esta política cuando cambien nuestros servicios o
            la normativa aplicable. Publicaremos la versión vigente en esta
            página, con su fecha de actualización.
        </p>
    </PaginaLegal>
</template>
