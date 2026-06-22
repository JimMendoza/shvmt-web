<script setup>
import Button from 'primevue/button';
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
            <span>Festividad del Señor de Huanca VMT</span>
            <span>Fe, tradición y comunidad</span>
        </footer>
    </div>
</template>
