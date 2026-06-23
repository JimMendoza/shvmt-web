<script setup>
import { onMounted, ref } from 'vue';
import EncabezadoSeccion from '@/modules/publico/componentes/EncabezadoSeccion.vue';
import TarjetaVacia from '@/modules/publico/componentes/TarjetaVacia.vue';
import { obtenerArchivoHistorico } from '@/modules/publico/servicios/publico.servicio';

const entradas = ref([]);

onMounted(async () => {
    const { data } = await obtenerArchivoHistorico();
    entradas.value = data;
});
</script>

<template>
    <section class="pagina-publica">
        <EncabezadoSeccion
            etiqueta="Archivo histórico"
            titulo="Memoria por años"
            descripcion="Registro histórico de mayordomías, familias y momentos importantes."
        />

        <TarjetaVacia v-if="!entradas.length" />

        <div class="archivo-publico">
            <article v-for="entrada in entradas" :key="entrada.id" class="entrada-historica">
                <span>{{ entrada.anio }}</span>
                <h2>{{ entrada.titulo }}</h2>
                <p>{{ entrada.descripcion }}</p>
                <small>{{ entrada.mayordomos }}</small>
            </article>
        </div>
    </section>
</template>
