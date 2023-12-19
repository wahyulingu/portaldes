<script setup>
import { computed } from 'vue';
import NavLink from './NavLink.vue';

const props = defineProps({ name: String, prefix: String });

const isPrefixed = computed(() => typeof props.prefix == 'string' && props.prefix.length > 0)
const isActive = computed(() => route().current(isPrefixed.value ? props.prefix + '*' : props.name));
const link = computed(() => route(isPrefixed.value ? props.prefix + '.' + props.name : props.name));
</script>

<template>
    <NavLink :href="link" :active="isActive">
        <slot />
    </NavLink>
</template>
