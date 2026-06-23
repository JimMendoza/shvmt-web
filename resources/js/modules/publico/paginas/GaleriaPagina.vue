<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerAlbumes } from '@/modules/publico/servicios/publico.servicio';

const albumes = ref([]);

onMounted(async () => {
    const { data } = await obtenerAlbumes();
    albumes.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Galería"
            titulo="Memoria fotográfica"
            descripcion="Álbumes que conservan los momentos centrales de cada año."
        />

        <TarjetaVacia v-if="!albumes.length" />

        <div class="rejilla-tarjetas">
            <RouterLink v-for="album in albumes" :key="album.id" :to="`/galeria/${album.slug}`" class="tarjeta-publica tarjeta-album">
                <span>{{ album.anio || 'Archivo' }}</span>
                <h2>{{ album.titulo }}</h2>
                <p>{{ album.descripcion || 'Registro fotográfico de la festividad.' }}</p>
            </RouterLink>
        </div>
    </section>
</template>
