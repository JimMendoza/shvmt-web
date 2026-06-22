<script setup>
import Button from 'primevue/button';
import { usarSitioStore } from '@/modules/inicio/store/sitio.store';

const sitio = usarSitioStore();
</script>

<template>
    <section class="portada">
        <div class="portada__resplandor" />
        <div class="portada__contenido">
            <span class="portada__etiqueta">Villa María del Triunfo</span>
            <p class="portada__lema">{{ sitio.lema }}</p>
            <h1>{{ sitio.nombre }}</h1>
            <p class="portada__descripcion">
                Una tradición de fe que une a nuestra comunidad y preserva su memoria para las nuevas generaciones.
            </p>
            <div class="portada__acciones">
                <Button label="Conocer la festividad" icon="pi pi-heart" />
                <Button label="Ver programa" icon="pi pi-calendar" severity="secondary" outlined />
            </div>
        </div>
    </section>
</template>
