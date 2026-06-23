<script setup>
import Button from 'primevue/button';
import { useRouter } from 'vue-router';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

const autenticacion = usarAutenticacionStore();
const router = useRouter();

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
                <RouterLink to="/admin/dashboard">
                    <i class="pi pi-home" />
                    Panel
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
