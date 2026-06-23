<script setup>
import { onMounted, ref } from 'vue';
import Button from 'primevue/button';
import { obtenerAlbumes, obtenerConfiguracion, obtenerPrograma } from '@/modules/publico/servicios/publico.servicio';

const configuracion = ref(null);
const programa = ref([]);
const albumes = ref([]);

onMounted(async () => {
    const [configuracionRespuesta, programaRespuesta, albumesRespuesta] = await Promise.all([
        obtenerConfiguracion(),
        obtenerPrograma(),
        obtenerAlbumes(),
    ]);

    configuracion.value = configuracionRespuesta.data;
    programa.value = programaRespuesta.data;
    albumes.value = albumesRespuesta.data;
});
</script>

<template>
    <section class="portada portada-final">
        <div class="portada__resplandor" />
        <div class="portada__contenido">
            <span class="portada__etiqueta">Villa María del Triunfo</span>
            <p class="portada__lema">Fe, tradición y memoria viva</p>
            <h1>{{ configuracion?.titulo_portada || configuracion?.nombre_sitio || 'Festividad del Señor de Huanca' }}</h1>
            <p class="portada__descripcion">
                {{ configuracion?.subtitulo_portada || 'Una celebración que conserva la devoción, la historia y el encuentro de nuestra comunidad.' }}
            </p>
            <div class="portada__acciones">
                <Button as="router-link" to="/historia" label="Conocer la historia" icon="pi pi-heart" />
                <Button as="router-link" to="/programa" label="Ver programa" icon="pi pi-calendar" severity="secondary" outlined />
            </div>
        </div>
    </section>

    <section class="bloque-publico bloque-destacado">
        <div>
            <span class="etiqueta-dorada">Programa oficial</span>
            <h2>{{ programa[0]?.titulo || 'Día central de la festividad' }}</h2>
            <p>{{ programa[0]?.descripcion || 'Consulta las actividades principales y acompaña cada momento de la celebración.' }}</p>
        </div>
        <RouterLink to="/programa" class="enlace-fino">Ver actividades <i class="pi pi-arrow-right" /></RouterLink>
    </section>

    <section class="bloque-publico">
        <div class="encabezado-linea">
            <div>
                <span class="etiqueta-dorada">Memoria visual</span>
                <h2>Galería de la festividad</h2>
            </div>
            <RouterLink to="/galeria">Ver galería</RouterLink>
        </div>
        <div class="rejilla-tarjetas">
            <article v-for="album in albumes.slice(0, 3)" :key="album.id" class="tarjeta-publica">
                <span>{{ album.anio || 'Archivo' }}</span>
                <h3>{{ album.titulo }}</h3>
                <p>{{ album.descripcion || 'Álbum fotográfico de la comunidad.' }}</p>
            </article>
        </div>
    </section>
</template>
