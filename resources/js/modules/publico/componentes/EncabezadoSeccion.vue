<script setup>
defineProps({
    etiqueta: {
        type: String,
        default: 'Festividad',
    },
    titulo: {
        type: String,
        required: true,
    },
    descripcion: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <header class="encabezado-seccion">
        <span>{{ etiqueta }}</span>
        <h1>{{ titulo }}</h1>
        <p v-if="descripcion">{{ descripcion }}</p>
    </header>
</template>
