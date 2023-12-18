<script setup>
import { computed } from 'vue';
import NavLink from './NavLink.vue';

const { name } = defineProps({ name: String });

const isActive = computed(() => route().current(name));
const link = computed(() => route(name));
</script>

<template>
    <NavLink :href="link" :active="isActive">
        <slot />
    </NavLink>
</template>
