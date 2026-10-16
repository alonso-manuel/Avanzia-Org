<script setup lang="ts">
import PaginaLegal from '@/components/public/PaginaLegal.vue';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();
</script>

<!-- Texto tomado del sitio anterior (avanzia.org/descargo-de-responsabilidad) -->
<template>
    <PaginaLegal :seo="seo" titulo="Descargo de Responsabilidad">
        <p>
            La información contenida en este sitio web es solo para fines de
            información general. La información es proporcionada por Avanzia
            América Latina y, aunque nos esforzamos por mantener la información
            actualizada y correcta, no hacemos representaciones ni garantías de
            ningún tipo, expresas o implícitas, sobre la integridad, exactitud,
            fiabilidad, idoneidad o disponibilidad con respecto al sitio web o
            la información, productos, servicios o gráficos relacionados
            contenidos en el sitio web para cualquier propósito. Cualquier
            confianza que deposites en dicha información es, por lo tanto,
            estrictamente bajo tu propio riesgo.
        </p>
        <p>
            En ningún caso seremos responsables por ninguna pérdida o daño,
            incluidos, sin limitación, pérdidas o daños indirectos o
            consecuentes, o cualquier pérdida o daño que surja de la pérdida de
            datos o beneficios que surjan del uso de este sitio web o en
            conexión con él.
        </p>
        <p>
            A través de este sitio web, puedes enlazar a otros sitios web que no
            están bajo el control de Avanzia América Latina. No tenemos control
            sobre la naturaleza, el contenido y la disponibilidad de esos
            sitios. La inclusión de cualquier enlace no implica necesariamente
            una recomendación ni respalda las opiniones expresadas en ellos.
        </p>
        <p>
            Se hace todo lo posible para mantener el sitio web funcionando sin
            problemas. Sin embargo, Avanzia América Latina no asume ninguna
            responsabilidad por, y no será responsable de, la falta de
            disponibilidad temporal del sitio web debido a problemas técnicos
            fuera de nuestro control.
        </p>
    </PaginaLegal>
</template>
