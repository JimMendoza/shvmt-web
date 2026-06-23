<script setup>
import Card from 'primevue/card';
import { computed, onMounted, ref } from 'vue';
import { obtenerResumen } from '@/modules/dashboard/servicios/panel.servicio';

const resumen = ref({
    programa: 0,
    galeria: 0,
    videos: 0,
    comunicados: 0,
});

const resumenes = computed(() => [
    ['Programa', resumen.value.programa],
    ['Galería', resumen.value.galeria],
    ['Videos', resumen.value.videos],
    ['Comunicados', resumen.value.comunicados],
]);

onMounted(async () => {
    const { data } = await obtenerResumen();
    resumen.value = data;
});
</script>

<template>
    <div>
        <div class="encabezado-pagina">
            <span>Resumen general</span>
            <h1>Panel administrativo</h1>
        </div>

        <div class="rejilla-resumen">
            <Card v-for="[nombre, cantidad] in resumenes" :key="nombre">
                <template #title>{{ nombre }}</template>
                <template #content>
                    <strong class="cantidad-resumen">{{ cantidad }}</strong>
                    <p>Contenido registrado.</p>
                </template>
            </Card>
        </div>
    </div>
</template>
