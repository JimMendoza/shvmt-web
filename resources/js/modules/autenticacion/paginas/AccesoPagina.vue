<script setup>
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Password from 'primevue/password';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

const autenticacion = usarAutenticacionStore();
const ruta = useRoute();
const router = useRouter();
const login = ref('');
const contrasena = ref('');
const error = ref('');
const procesando = ref(false);

async function ingresar() {
    error.value = '';
    procesando.value = true;

    try {
        await autenticacion.iniciarSesion({
            login: login.value,
            contrasena: contrasena.value,
        });

        const destino = autenticacion.usuario.debe_cambiar_contrasena
            ? '/admin/cuenta'
            : ruta.query.redireccion || '/admin/dashboard';
        await router.push(destino);
    } catch (excepcion) {
        error.value = excepcion.response?.data?.errors?.login?.[0]
            || excepcion.response?.data?.errors?.correo?.[0]
            || excepcion.response?.data?.message
            || 'No se pudo iniciar sesión.';
    } finally {
        procesando.value = false;
    }
}
</script>

<template>
    <Card class="tarjeta-acceso">
        <template #title>Acceso administrativo</template>
        <template #subtitle>Festividad del Señor de Huanca VMT</template>
        <template #content>
            <form class="formulario-acceso" @submit.prevent="ingresar">
                <Message v-if="error" severity="error">{{ error }}</Message>

                <label for="login">Usuario o correo</label>
                <InputText id="login" v-model="login" autocomplete="username" fluid />

                <label for="contrasena">Contraseña</label>
                <Password
                    id="contrasena"
                    v-model="contrasena"
                    :feedback="false"
                    autocomplete="current-password"
                    toggle-mask
                    fluid
                />

                <Button
                    type="submit"
                    label="Ingresar"
                    icon="pi pi-sign-in"
                    :loading="procesando"
                    fluid
                />
            </form>
        </template>
    </Card>
</template>
