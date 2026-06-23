<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerMayordomia } from '@/modules/publico/servicios/publico.servicio';

const mayordomia = ref(null);

onMounted(async () => {
    const { data } = await obtenerMayordomia();
    mayordomia.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Mayordomía"
            titulo="Servicio, fe y compromiso"
            descripcion="La mayordomía acompaña y sostiene la celebración anual de la comunidad."
        />

        <TarjetaVacia v-if="!mayordomia" />

        <article v-else class="tarjeta-mayordomia">
            <span>{{ mayordomia.anio }}</span>
            <h2>{{ mayordomia.titulo }}</h2>
            <h3>{{ mayordomia.nombre_familia }}</h3>
            <p>{{ mayordomia.mensaje }}</p>
        </article>
    </section>
</template>
