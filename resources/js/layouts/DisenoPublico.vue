<script setup>
import Button from 'primevue/button';

const enlaces = [
    { texto: 'Historia', ruta: '/historia' },
    { texto: 'Mayordomía', ruta: '/mayordomia' },
    { texto: 'Programa', ruta: '/programa' },
    { texto: 'Galería', ruta: '/galeria' },
    { texto: 'Videos', ruta: '/videos' },
    { texto: 'Ubicación', ruta: '/ubicacion' },
    { texto: 'Archivo', ruta: '/archivo-historico' },
];
</script>

<template>
    <div class="diseno-publico">
        <header class="cabecera-publica">
            <RouterLink to="/" class="marca-publica">
                <span class="marca-publica__simbolo">SH</span>
                <span>
                    <strong>Señor de Huanca</strong>
                    <small>Villa María del Triunfo</small>
                </span>
            </RouterLink>

            <nav class="navegacion-publica">
                <RouterLink v-for="enlace in enlaces" :key="enlace.ruta" :to="enlace.ruta">
                    {{ enlace.texto }}
                </RouterLink>
            </nav>

            <Button
                as="a"
                href="/admin/login"
                label="Administración"
                icon="pi pi-user"
                severity="secondary"
                outlined
                size="small"
            />
        </header>

        <main>
            <RouterView />
        </main>

        <footer class="pie-publico">
            <div>
                <strong>Festividad del Señor de Huanca VMT</strong>
                <span>Fe, tradición y comunidad</span>
            </div>
            <div class="pie-publico__enlaces">
                <RouterLink to="/programa">Programa</RouterLink>
                <RouterLink to="/galeria">Galería</RouterLink>
                <RouterLink to="/ubicacion">Ubicación</RouterLink>
            </div>
        </footer>

        <a class="boton-whatsapp" href="https://wa.me/51999999999" target="_blank" rel="noreferrer" aria-label="WhatsApp">
            <i class="pi pi-whatsapp" />
        </a>
    </div>
</template>
