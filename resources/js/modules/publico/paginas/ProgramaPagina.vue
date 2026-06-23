<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerPrograma } from '@/modules/publico/servicios/publico.servicio';

const dias = ref([]);

onMounted(async () => {
    const { data } = await obtenerPrograma();
    dias.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Programa"
            titulo="Programa oficial"
            descripcion="Actividades religiosas, culturales y comunitarias de la festividad."
        />

        <TarjetaVacia v-if="!dias.length" />

        <div class="programa-publico">
            <article v-for="dia in dias" :key="dia.id" class="dia-programa-publico">
                <header>
                    <span>{{ dia.fecha }}</span>
                    <h2>{{ dia.titulo }}</h2>
                    <p>{{ dia.descripcion }}</p>
                </header>
                <div class="actividades-publicas">
                    <div v-for="actividad in dia.actividades" :key="actividad.id" class="actividad-publica">
                        <strong>{{ actividad.hora_inicio || 'Hora por confirmar' }}</strong>
                        <div>
                            <h3>{{ actividad.titulo }}</h3>
                            <p>{{ actividad.nombre_lugar || actividad.direccion || actividad.descripcion }}</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
