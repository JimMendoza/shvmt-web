<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import { obtenerVideo } from '@/modules/publico/servicios/publico.servicio';

const route = useRoute();
const video = ref(null);

async function cargar() {
    const { data } = await obtenerVideo(route.params.slug);
    video.value = data;
}

watch(() => route.params.slug, cargar);
onMounted(cargar);
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Video"
            :titulo="video?.titulo || 'Video'"
            :descripcion="video?.descripcion || 'Registro audiovisual de la festividad.'"
        />

        <div v-if="video?.url_incrustado" class="video-embebido">
            <iframe
                :src="video.url_incrustado"
                :title="video.titulo"
                loading="lazy"
                allowfullscreen
            />
        </div>

        <a v-if="video?.url_video" :href="video.url_video" target="_blank" rel="noreferrer" class="enlace-fino">
            Abrir video original <i class="pi pi-external-link" />
        </a>
    </section>
</template>
