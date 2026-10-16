<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    Building2,
    CircleCheck,
    FileSignature,
    Handshake,
    Send,
    UserRound,
    X,
} from '@lucide/vue';
import { ref, watch } from 'vue';
import { store } from '@/actions/App/Http/Controllers/Public/SolicitudConvenioController';
import ModalPublico from '@/components/public/ModalPublico.vue';
import { EMAIL, whatsapp } from '@/lib/public/contacto';
import type { OpcionesSolicitud } from '@/types';

const props = defineProps<{
    abierto: boolean;
    opciones: OpcionesSolicitud;
}>();

const emit = defineEmits<{ cerrar: [] }>();

const beneficios = [
    {
        titulo: 'Licencias Institucionales',
        texto: 'Acceso a Avanzia STUDIO para toda tu plana docente con tarifas preferenciales.',
    },
    {
        titulo: 'Certificación Oficial',
        texto: 'Emisión de certificados con validación por código QR internacional.',
    },
    {
        titulo: 'Portal de Métrica',
        texto: 'Seguimiento en tiempo real del progreso y las horas capacitadas de tu equipo.',
    },
    {
        titulo: 'Masterclasses Exclusivas',
        texto: 'Sesiones sincrónicas cerradas con expertos en innovación educativa.',
    },
];

const OTRO = 'Otro';
const enviada = ref(false);
const paisElegido = ref(props.opciones.paises[0] ?? OTRO);
const otroPais = ref('');

const form = useForm({
    institucion: '',
    tipo_institucion: '',
    pais: '',
    sitio_web: '',
    representante: '',
    cargo: '',
    correo: '',
    telefono: '',
    interes: '',
    docentes: '' as number | '',
    mensaje: '',
    acepta: false,
    empresa_web: '',
});

watch(
    () => props.abierto,
    (abierto) => {
        if (abierto) {
            enviada.value = false;
        }
    },
);

function enviar() {
    form.transform((datos) => ({
        ...datos,
        pais: paisElegido.value === OTRO ? otroPais.value : paisElegido.value,
    })).post(store.url(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            enviada.value = true;
            form.reset();
            otroPais.value = '';
        },
    });
}

const campo =
    'w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm transition-all outline-none focus:ring-2 focus:ring-avanzia-purple';
const etiqueta = 'mb-1.5 block text-xs font-bold text-slate-600';
const seccion =
    'mb-4 flex items-center gap-2 text-[11px] font-black tracking-widest text-avanzia-purple uppercase';
</script>

<template>
    <ModalPublico :abierto="abierto" @cerrar="emit('cerrar')">
        <div
            class="relative my-auto flex w-full max-w-5xl flex-col overflow-hidden rounded-[2rem] bg-white shadow-2xl md:flex-row"
        >
            <button
                type="button"
                aria-label="Cerrar"
                class="absolute top-4 right-4 z-20 flex size-10 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-800 md:top-6 md:right-6"
                @click="emit('cerrar')"
            >
                <X class="size-5" />
            </button>

            <!-- Beneficios -->
            <div
                class="flex flex-col justify-between border-r border-slate-100 bg-slate-50 p-8 md:w-2/5 md:p-10"
            >
                <div>
                    <div
                        class="mb-6 flex size-12 items-center justify-center rounded-xl border border-slate-100 bg-white text-avanzia-purple shadow-sm"
                    >
                        <Handshake class="size-6" />
                    </div>
                    <h3
                        class="mb-6 text-2xl leading-tight font-black text-slate-800"
                    >
                        Beneficios de la<br /><span class="text-avanzia-orange"
                            >Alianza Avanzia</span
                        >
                    </h3>
                    <ul class="space-y-5">
                        <li
                            v-for="beneficio in beneficios"
                            :key="beneficio.titulo"
                            class="flex items-start gap-3"
                        >
                            <CircleCheck
                                class="mt-0.5 size-4 shrink-0 text-avanzia-orange"
                            />
                            <div>
                                <strong class="block text-sm text-slate-800">{{
                                    beneficio.titulo
                                }}</strong>
                                <span class="text-xs text-slate-500">{{
                                    beneficio.texto
                                }}</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-10 border-t border-slate-200 pt-6">
                    <p
                        class="mb-2 text-xs font-bold tracking-widest text-slate-400 uppercase"
                    >
                        ¿Consultas directas?
                    </p>
                    <a
                        :href="`mailto:${EMAIL}`"
                        class="text-sm font-semibold text-avanzia-purple transition-colors hover:text-avanzia-orange"
                        >{{ EMAIL }}</a
                    >
                </div>
            </div>

            <!-- Enviada -->
            <div
                v-if="enviada"
                class="flex flex-col items-center justify-center p-10 text-center md:w-3/5"
            >
                <CircleCheck class="mb-4 size-14 text-green-500" />
                <h3 class="mb-2 text-2xl font-black text-slate-800">
                    Solicitud enviada
                </h3>
                <p class="mb-8 max-w-sm text-slate-500">
                    Recibimos los datos de tu institución. Nuestro equipo los
                    revisará para iniciar la evaluación del convenio.
                </p>
                <a
                    :href="
                        whatsapp(
                            'Hola, acabo de enviar una solicitud de convenio institucional desde la web.',
                        )
                    "
                    target="_blank"
                    rel="noopener"
                    class="text-sm font-semibold text-avanzia-ochre hover:underline"
                >
                    ¿Prefieres conversar ahora? Escríbenos por WhatsApp
                </a>
            </div>

            <!-- Formulario -->
            <div v-else class="relative bg-white p-8 md:w-3/5 md:p-10">
                <div class="mb-8 pr-10">
                    <h3 class="mb-2 text-2xl font-black text-slate-800">
                        Intención formal de convenio
                    </h3>
                    <p class="text-sm text-slate-500">
                        Completa los datos para iniciar la evaluación
                        institucional.
                    </p>
                </div>

                <form class="space-y-6" @submit.prevent="enviar">
                    <!-- 1. Institución -->
                    <fieldset>
                        <legend :class="seccion">
                            <Building2 class="size-4" /> 1. Datos de la
                            Institución
                        </legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="sc-institucion" :class="etiqueta"
                                    >Nombre de la Institución *</label
                                >
                                <input
                                    id="sc-institucion"
                                    v-model="form.institucion"
                                    type="text"
                                    required
                                    maxlength="160"
                                    placeholder="Ej. IEP San Miguel"
                                    :class="campo"
                                />
                            </div>
                            <div>
                                <label for="sc-tipo" :class="etiqueta"
                                    >Tipo *</label
                                >
                                <select
                                    id="sc-tipo"
                                    v-model="form.tipo_institucion"
                                    required
                                    :class="[campo, 'cursor-pointer']"
                                >
                                    <option value="" disabled>
                                        Seleccione...
                                    </option>
                                    <option
                                        v-for="(
                                            nombre, clave
                                        ) in opciones.tiposInstitucion"
                                        :key="clave"
                                        :value="clave"
                                    >
                                        {{ nombre }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="sc-pais" :class="etiqueta"
                                    >País *</label
                                >
                                <select
                                    id="sc-pais"
                                    v-model="paisElegido"
                                    required
                                    :class="[campo, 'cursor-pointer']"
                                >
                                    <option
                                        v-for="pais in opciones.paises"
                                        :key="pais"
                                        :value="pais"
                                    >
                                        {{ pais }}
                                    </option>
                                    <option :value="OTRO">Otro</option>
                                </select>
                                <input
                                    v-if="paisElegido === OTRO"
                                    v-model="otroPais"
                                    type="text"
                                    required
                                    maxlength="80"
                                    aria-label="Especifique su país"
                                    placeholder="Especifique su país"
                                    :class="[campo, 'mt-2']"
                                />
                            </div>
                            <div>
                                <label for="sc-web" :class="etiqueta"
                                    >Sitio Web</label
                                >
                                <input
                                    id="sc-web"
                                    v-model="form.sitio_web"
                                    type="text"
                                    inputmode="url"
                                    maxlength="255"
                                    placeholder="Ej. www.institucion.edu"
                                    :class="campo"
                                />
                            </div>
                        </div>
                    </fieldset>

                    <!-- 2. Representante -->
                    <fieldset class="border-t border-slate-100 pt-4">
                        <legend :class="[seccion, 'pt-4']">
                            <UserRound class="size-4" /> 2. Representante Legal
                        </legend>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="sc-nombre" :class="etiqueta"
                                    >Nombre Completo *</label
                                >
                                <input
                                    id="sc-nombre"
                                    v-model="form.representante"
                                    type="text"
                                    required
                                    maxlength="120"
                                    autocomplete="name"
                                    placeholder="Nombre del contacto"
                                    :class="campo"
                                />
                            </div>
                            <div>
                                <label for="sc-cargo" :class="etiqueta"
                                    >Cargo *</label
                                >
                                <input
                                    id="sc-cargo"
                                    v-model="form.cargo"
                                    type="text"
                                    required
                                    maxlength="120"
                                    autocomplete="organization-title"
                                    placeholder="Ej. Director Académico"
                                    :class="campo"
                                />
                            </div>
                            <div>
                                <label for="sc-correo" :class="etiqueta"
                                    >Correo Institucional *</label
                                >
                                <input
                                    id="sc-correo"
                                    v-model="form.correo"
                                    type="email"
                                    required
                                    maxlength="160"
                                    autocomplete="email"
                                    placeholder="correo@institucion.edu"
                                    :class="campo"
                                />
                            </div>
                            <div>
                                <label for="sc-telefono" :class="etiqueta"
                                    >Teléfono / WhatsApp *</label
                                >
                                <input
                                    id="sc-telefono"
                                    v-model="form.telefono"
                                    type="tel"
                                    required
                                    maxlength="40"
                                    autocomplete="tel"
                                    placeholder="+51 999 999 999"
                                    :class="campo"
                                />
                            </div>
                        </div>
                    </fieldset>

                    <!-- 3. Solicitud -->
                    <fieldset class="border-t border-slate-100 pt-4">
                        <legend :class="[seccion, 'pt-4']">
                            <FileSignature class="size-4" /> 3. Detalles de
                            Solicitud
                        </legend>
                        <div class="mb-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="sc-interes" :class="etiqueta"
                                    >Interés Principal *</label
                                >
                                <select
                                    id="sc-interes"
                                    v-model="form.interes"
                                    required
                                    :class="[campo, 'cursor-pointer']"
                                >
                                    <option value="" disabled>
                                        Seleccione...
                                    </option>
                                    <option
                                        v-for="(
                                            nombre, clave
                                        ) in opciones.intereses"
                                        :key="clave"
                                        :value="clave"
                                    >
                                        {{ nombre }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="sc-docentes" :class="etiqueta"
                                    >N° aprox. de docentes *</label
                                >
                                <input
                                    id="sc-docentes"
                                    v-model="form.docentes"
                                    type="number"
                                    required
                                    min="1"
                                    placeholder="Ej. 50"
                                    :class="campo"
                                />
                            </div>
                        </div>
                        <label for="sc-mensaje" :class="etiqueta"
                            >Mensaje o necesidad específica</label
                        >
                        <textarea
                            id="sc-mensaje"
                            v-model="form.mensaje"
                            rows="2"
                            maxlength="2000"
                            placeholder="Cuéntanos brevemente sobre los objetivos de tu institución..."
                            :class="[campo, 'resize-none']"
                        />
                    </fieldset>

                    <!-- Trampa para bots: oculta para las personas -->
                    <div class="hidden" aria-hidden="true">
                        <label for="sc-empresa">Empresa web</label>
                        <input
                            id="sc-empresa"
                            v-model="form.empresa_web"
                            type="text"
                            tabindex="-1"
                            autocomplete="off"
                        />
                    </div>

                    <label
                        class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4"
                    >
                        <input
                            v-model="form.acepta"
                            type="checkbox"
                            required
                            class="mt-0.5 size-5 shrink-0 accent-avanzia-purple"
                        />
                        <span class="text-xs leading-relaxed text-slate-600">
                            Declaro que los datos proporcionados son verídicos y
                            cuento con la autorización para solicitar este
                            convenio institucional. Acepto ser contactado por el
                            equipo de Avanzia.
                        </span>
                    </label>

                    <p
                        v-if="Object.keys(form.errors).length"
                        class="rounded-xl bg-red-50 p-3 text-sm text-red-600"
                    >
                        {{ Object.values(form.errors)[0] }}
                    </p>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-avanzia-navy py-4 text-base font-black text-white shadow-lg transition-all hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-xl disabled:opacity-70"
                        :disabled="form.processing"
                    >
                        <Send class="size-4" />
                        {{
                            form.processing
                                ? 'Enviando…'
                                : 'Enviar solicitud de convenio'
                        }}
                    </button>
                </form>
            </div>
        </div>
    </ModalPublico>
</template>
