<script setup lang="ts">
import { Clock, ShoppingCart, Trash2, X } from '@lucide/vue';
import { onBeforeUnmount, watch } from 'vue';
import { useCarrito } from '@/lib/public/carrito';

const { items, cantidad, abierto, quitar, vaciar, enlacePedido } = useCarrito();

const alPresionarTecla = (e: KeyboardEvent) => {
    if (e.key === 'Escape') {
        abierto.value = false;
    }
};

// Solo se ejecuta en el navegador: el panel arranca cerrado
watch(abierto, (valor) => {
    if (valor) {
        document.addEventListener('keydown', alPresionarTecla);
    } else {
        document.removeEventListener('keydown', alPresionarTecla);
    }
});

onBeforeUnmount(() =>
    document.removeEventListener('keydown', alPresionarTecla),
);
</script>

<template>
    <!-- Botón flotante: aparece al cerrar el panel si hay cursos, encima del de WhatsApp -->
    <Transition
        enter-from-class="scale-50 opacity-0"
        leave-to-class="scale-50 opacity-0"
        enter-active-class="transition duration-200"
        leave-active-class="transition duration-200"
    >
        <button
            v-if="cantidad > 0 && !abierto"
            type="button"
            :aria-label="`Ver carrito (${cantidad} ${cantidad === 1 ? 'curso' : 'cursos'})`"
            class="fixed right-5 bottom-24 z-40 flex size-14 items-center justify-center rounded-full bg-avanzia-orange text-white shadow-xl shadow-avanzia-orange/30 transition-transform hover:scale-110"
            @click="abierto = true"
        >
            <ShoppingCart class="size-7" />
            <span
                class="absolute -top-1 -right-1 flex size-6 items-center justify-center rounded-full bg-avanzia-ink text-xs font-black ring-2 ring-white"
                >{{ cantidad }}</span
            >
        </button>
    </Transition>

    <!-- Fondo oscuro -->
    <Transition
        enter-from-class="opacity-0"
        leave-to-class="opacity-0"
        enter-active-class="transition-opacity duration-300"
        leave-active-class="transition-opacity duration-300"
    >
        <div
            v-if="abierto"
            aria-hidden="true"
            class="fixed inset-0 z-[90] bg-slate-900/50 backdrop-blur-sm"
            @click="abierto = false"
        />
    </Transition>

    <!-- Panel lateral -->
    <Transition
        enter-from-class="translate-x-full"
        leave-to-class="translate-x-full"
        enter-active-class="transition-transform duration-300 ease-out"
        leave-active-class="transition-transform duration-200 ease-in"
    >
        <aside
            v-if="abierto"
            role="dialog"
            aria-modal="true"
            aria-labelledby="carrito-titulo"
            class="fixed inset-y-0 right-0 z-[95] flex w-full max-w-sm flex-col bg-white font-landing shadow-2xl"
        >
            <header
                class="flex items-center justify-between border-b border-slate-100 px-6 py-5"
            >
                <h2
                    id="carrito-titulo"
                    class="flex items-center gap-2 text-xl font-black text-slate-900"
                >
                    <ShoppingCart class="size-6 text-avanzia-orange" />
                    Tu carrito ({{ cantidad }})
                </h2>
                <button
                    type="button"
                    aria-label="Cerrar carrito"
                    class="flex size-9 items-center justify-center rounded-full text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-800"
                    @click="abierto = false"
                >
                    <X class="size-6" />
                </button>
            </header>

            <!-- Vacío -->
            <div
                v-if="cantidad === 0"
                class="flex flex-1 flex-col items-center justify-center gap-4 px-8 text-center"
            >
                <div
                    class="flex size-20 items-center justify-center rounded-full bg-avanzia-cream/50"
                >
                    <ShoppingCart class="size-9 text-avanzia-ochre" />
                </div>
                <p class="font-semibold text-slate-600">
                    Aún no agregaste cursos.
                </p>
                <a
                    href="/#cursos"
                    class="rounded-full bg-avanzia-orange px-6 py-3 font-bold text-white transition-colors hover:bg-avanzia-orange-dark"
                    @click="abierto = false"
                >
                    Ver cursos
                </a>
            </div>

            <template v-else>
                <ul class="flex-1 space-y-3 overflow-y-auto px-6 py-5">
                    <li
                        v-for="item in items"
                        :key="item.id"
                        class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-3"
                    >
                        <img
                            v-if="item.imagen"
                            :src="item.imagen"
                            alt=""
                            loading="lazy"
                            class="size-16 shrink-0 rounded-xl object-cover"
                        />
                        <div
                            v-else
                            class="size-16 shrink-0 rounded-xl bg-avanzia-cream"
                        />
                        <div class="min-w-0 flex-1">
                            <p
                                class="text-[10px] font-black tracking-wider text-avanzia-purple uppercase"
                            >
                                {{ item.categoria }}
                            </p>
                            <p class="leading-tight font-bold text-slate-900">
                                {{ item.titulo }}
                            </p>
                            <p
                                v-if="
                                    item.horas || item.duracion || item.gratuito
                                "
                                class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500"
                            >
                                <span
                                    v-if="item.horas || item.duracion"
                                    class="flex items-center gap-1"
                                >
                                    <Clock class="size-3 text-avanzia-orange" />
                                    {{
                                        item.horas
                                            ? `${item.horas} horas`
                                            : item.duracion
                                    }}
                                </span>
                                <span
                                    v-if="item.gratuito"
                                    class="rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-black text-white uppercase"
                                    >Gratis</span
                                >
                            </p>
                        </div>
                        <button
                            type="button"
                            :aria-label="`Quitar ${item.titulo}`"
                            class="flex size-8 shrink-0 items-center justify-center self-start rounded-lg text-slate-400 transition-colors hover:bg-red-50 hover:text-red-500"
                            @click="quitar(item.id)"
                        >
                            <Trash2 class="size-4" />
                        </button>
                    </li>
                </ul>

                <footer class="space-y-3 border-t border-slate-100 px-6 py-5">
                    <p class="text-sm text-slate-500">
                        Envía tu pedido y coordinamos por WhatsApp las fechas,
                        el precio y la forma de pago.
                    </p>
                    <a
                        :href="enlacePedido()"
                        target="_blank"
                        rel="noopener"
                        class="flex w-full items-center justify-center gap-2 rounded-2xl bg-[#25d366] py-4 text-lg font-black text-white shadow-lg transition-all hover:-translate-y-0.5 hover:bg-[#1ebe5b]"
                    >
                        Enviar pedido por WhatsApp
                    </a>
                    <button
                        type="button"
                        class="w-full py-2 text-sm font-semibold text-slate-400 transition-colors hover:text-red-500"
                        @click="vaciar()"
                    >
                        Vaciar carrito
                    </button>
                </footer>
            </template>
        </aside>
    </Transition>
</template>
