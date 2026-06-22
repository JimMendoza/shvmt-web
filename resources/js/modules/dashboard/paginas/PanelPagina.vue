<script setup>
import Card from 'primevue/card';

const resumenes = ['Programa', 'Galería', 'Videos', 'Comunicados'];
</script>

<template>
    <div>
        <div class="encabezado-pagina">
            <span>Resumen general</span>
            <h1>Panel administrativo</h1>
        </div>

        <div class="rejilla-resumen">
            <Card v-for="item in resumenes" :key="item">
                <template #title>{{ item }}</template>
                <template #content>
                    <strong class="cantidad-resumen">0</strong>
                    <p>Disponible en las siguientes fases.</p>
                </template>
            </Card>
        </div>
    </div>
</template>
