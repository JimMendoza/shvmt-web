<script setup>
import Button from 'primevue/button';
import { useRouter } from 'vue-router';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';
import { menuAdmin } from '@/modules/admin/config/recursos';

const autenticacion = usarAutenticacionStore();
const router = useRouter();

const opcionesMenu = menuAdmin.filter((opcion) => autenticacion.tienePermiso(opcion.permiso));

async function salir() {
    await autenticacion.cerrarSesion();
    await router.push('/admin/login');
}
</script>

<template>
    <div class="diseno-administrativo">
        <aside class="barra-lateral">
            <RouterLink to="/" class="marca-administrativa">
                <span class="marca-publica__simbolo">SH</span>
                <span>Señor de Huanca VMT</span>
            </RouterLink>

            <nav class="menu-administrativo">
                <RouterLink v-for="opcion in opcionesMenu" :key="opcion.ruta" :to="opcion.ruta">
                    <i :class="opcion.icono" />
                    {{ opcion.etiqueta }}
                </RouterLink>
            </nav>
        </aside>

        <section class="contenido-administrativo">
            <header class="cabecera-administrativa">
                <div>
                    <strong>{{ autenticacion.usuario?.nombre }}</strong>
                    <small class="correo-usuario">{{ autenticacion.usuario?.correo }}</small>
                </div>
                <Button label="Cerrar sesión" icon="pi pi-sign-out" text @click="salir" />
            </header>

            <main class="pagina-administrativa">
                <RouterView />
            </main>
        </section>
    </div>
</template>
