<script setup>
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { ref } from 'vue';

const correo = ref('');
const contrasena = ref('');
</script>

<template>
    <Card class="tarjeta-acceso">
        <template #title>Acceso administrativo</template>
        <template #subtitle>Festividad del Señor de Huanca VMT</template>
        <template #content>
            <form class="formulario-acceso" @submit.prevent>
                <label for="correo">Correo</label>
                <InputText id="correo" v-model="correo" type="email" fluid />

                <label for="contrasena">Contraseña</label>
                <Password
                    id="contrasena"
                    v-model="contrasena"
                    :feedback="false"
                    toggle-mask
                    fluid
                />

                <Button type="submit" label="Ingresar" icon="pi pi-sign-in" fluid disabled />
                <small>El inicio de sesión se habilitará en la fase 2.</small>
            </form>
        </template>
    </Card>
</template>
