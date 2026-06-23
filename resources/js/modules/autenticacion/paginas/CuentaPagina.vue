<script setup>
import Button from 'primevue/button';
import Card from 'primevue/card';
import Message from 'primevue/message';
import Password from 'primevue/password';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

const autenticacion = usarAutenticacionStore();
const router = useRouter();
const contrasenaActual = ref('');
const contrasena = ref('');
const confirmacion = ref('');
const error = ref('');
const procesando = ref(false);

async function guardar() {
    error.value = '';
    procesando.value = true;

    try {
        await autenticacion.cambiarContrasena({
            contrasena_actual: contrasenaActual.value,
            contrasena: contrasena.value,
            contrasena_confirmation: confirmacion.value,
        });
        await router.push('/admin/dashboard');
    } catch (excepcion) {
        const errores = excepcion.response?.data?.errors;
        error.value = errores ? Object.values(errores)[0][0] : 'No se pudo actualizar la contraseña.';
    } finally {
        procesando.value = false;
    }
}
</script>

<template>
    <div class="pagina-cuenta">
        <Card class="tarjeta-cuenta">
            <template #title>Cambiar contraseña</template>
            <template #subtitle>Debes definir una contraseña personal antes de continuar.</template>
            <template #content>
                <form class="formulario-acceso" @submit.prevent="guardar">
                    <Message v-if="error" severity="error">{{ error }}</Message>

                    <label for="actual">Contraseña actual</label>
                    <Password id="actual" v-model="contrasenaActual" :feedback="false" toggle-mask fluid />

                    <label for="nueva">Nueva contraseña</label>
                    <Password id="nueva" v-model="contrasena" toggle-mask fluid />

                    <label for="confirmacion">Confirmar contraseña</label>
                    <Password id="confirmacion" v-model="confirmacion" :feedback="false" toggle-mask fluid />

                    <Button type="submit" label="Guardar contraseña" :loading="procesando" fluid />
                </form>
            </template>
        </Card>
    </div>
</template>
