<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerAlbum } from '@/modules/publico/servicios/publico.servicio';

const route = useRoute();
const album = ref(null);

async function cargar() {
    const { data } = await obtenerAlbum(route.params.slug);
    album.value = data;
}

watch(() => route.params.slug, cargar);
onMounted(cargar);
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Galería"
            :titulo="album?.titulo || 'Detalle de álbum'"
            :descripcion="album?.descripcion || 'Fotografías de la festividad.'"
        />

        <TarjetaVacia v-if="!album?.fotos?.length" />

        <div v-else class="rejilla-fotos">
            <figure v-for="foto in album.fotos" :key="foto.id" class="foto-publica">
                <div class="marco-foto">
                    <span>{{ foto.titulo || 'Fotografía' }}</span>
                </div>
                <figcaption>{{ foto.descripcion }}</figcaption>
            </figure>
        </div>
    </section>
</template>
