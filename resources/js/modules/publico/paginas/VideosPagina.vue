<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerVideos } from '@/modules/publico/servicios/publico.servicio';

const videos = ref([]);

onMounted(async () => {
    const { data } = await obtenerVideos();
    videos.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Videos"
            titulo="Registro audiovisual"
            descripcion="Videos embebidos de invitaciones, procesiones, misas y memoria de archivo."
        />

        <TarjetaVacia v-if="!videos.length" />

        <div class="rejilla-tarjetas">
            <article v-for="video in videos" :key="video.id" class="tarjeta-publica">
                <span>{{ video.categoria || 'Video' }}</span>
                <h2>{{ video.titulo }}</h2>
                <p>{{ video.descripcion || 'Video de la festividad.' }}</p>
                <RouterLink :to="`/videos/${video.slug}`">Ver video</RouterLink>
            </article>
        </div>
    </section>
</template>
