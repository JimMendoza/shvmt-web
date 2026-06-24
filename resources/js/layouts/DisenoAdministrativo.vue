<script setup>
import Button from 'primevue/button';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import ElementoMenuAdmin from '@/modules/admin/componentes/ElementoMenuAdmin.vue';
import { obtenerMenu } from '@/modules/admin/servicios/admin.servicio';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

const autenticacion = usarAutenticacionStore();
const router = useRouter();
const opcionesMenu = ref([]);

async function cargarMenu() {
    const { data } = await obtenerMenu();
    opcionesMenu.value = data;
}

async function salir() {
    await autenticacion.cerrarSesion();
    await router.push('/admin/login');
}

onMounted(cargarMenu);
</script>

<template>
    <div class="diseno-administrativo">
        <aside class="barra-lateral">
            <RouterLink to="/" class="marca-administrativa">
                <span class="marca-publica__simbolo">SH</span>
                <span>Señor de Huanca VMT</span>
            </RouterLink>

            <nav class="menu-administrativo">
                <section v-for="menu in opcionesMenu" :key="menu.id" class="menu-administrativo__bloque">
                    <div class="menu-administrativo__seccion">
                        <i v-if="menu.icon" :class="menu.icon" />
                        <span>{{ menu.title }}</span>
                    </div>
                    <ElementoMenuAdmin
                        v-for="item in menu.children"
                        :key="`${menu.id}-${item.id}`"
                        :item="item"
                    />
                </section>
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
