<script setup>
defineProps({
    item: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div v-if="item.heading" class="menu-administrativo__titulo">
        {{ item.heading }}
    </div>

    <div v-else-if="item.children?.length" class="menu-administrativo__grupo">
        <div class="menu-administrativo__grupo-titulo">
            <i v-if="item.icon" :class="item.icon" />
            <span>{{ item.title }}</span>
        </div>
        <div class="menu-administrativo__hijos">
            <ElementoMenuAdmin
                v-for="hijo in item.children"
                :key="`${item.id}-${hijo.id}`"
                :item="hijo"
            />
        </div>
    </div>

    <RouterLink v-else :to="item.to || '#'" class="menu-administrativo__enlace">
        <i v-if="item.icon" :class="item.icon" />
        <span>{{ item.title }}</span>
    </RouterLink>
</template>
