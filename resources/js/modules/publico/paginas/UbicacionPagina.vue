<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerUbicaciones } from '@/modules/publico/servicios/publico.servicio';

const ubicaciones = ref([]);

onMounted(async () => {
    const { data } = await obtenerUbicaciones();
    ubicaciones.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Ubicación"
            titulo="Puntos de encuentro"
            descripcion="Lugares principales de celebración, concentración y referencia."
        />

        <TarjetaVacia v-if="!ubicaciones.length" />

        <div class="rejilla-tarjetas">
            <article v-for="ubicacion in ubicaciones" :key="ubicacion.id" class="tarjeta-publica">
                <span>{{ ubicacion.tipo || 'Lugar' }}</span>
                <h2>{{ ubicacion.titulo }}</h2>
                <p>{{ ubicacion.direccion || ubicacion.descripcion }}</p>
                <a v-if="ubicacion.url_mapa" :href="ubicacion.url_mapa" target="_blank" rel="noreferrer">Abrir mapa</a>
            </article>
        </div>
    </section>
</template>
