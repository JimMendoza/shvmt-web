<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerHistoria } from '@/modules/publico/servicios/publico.servicio';

const secciones = ref([]);

onMounted(async () => {
    const { data } = await obtenerHistoria();
    secciones.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Historia"
            titulo="La devoción que nos reúne"
            descripcion="Una memoria viva construida por familias, mayordomos y devotos."
        />

        <TarjetaVacia v-if="!secciones.length" />

        <div class="linea-historia">
            <article v-for="seccion in secciones" :key="seccion.id" class="item-historia">
                <span>{{ seccion.subtitulo || 'Memoria local' }}</span>
                <h2>{{ seccion.titulo }}</h2>
                <p>{{ seccion.contenido }}</p>
            </article>
        </div>
    </section>
</template>
