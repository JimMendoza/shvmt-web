<script setup>
import Button from 'primevue/button';
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
                <strong>Administración</strong>
                <Button label="Cerrar sesión" icon="pi pi-sign-out" text disabled />
            </header>

            <main class="pagina-administrativa">
                <RouterView />
            </main>
        </section>
    </div>
</template>
