<script setup lang="ts">
import Dropdown from '../Dropdown.vue';

defineProps({
    icon: {
        type: Array,
        required: true
    },

    title: {
        type: String,
        required: true
    }
})

</script>

<template>
    <Dropdown>
        <template #trigger>
            <button
                class="block w-full px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                <div class="flex justify-between">
                    <div class="flex items-center justify-start">
                        {{ title }}
                    </div>
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </div>
            </button>
        </template>
        <template #content>
            <slot />
        </template>
    </Dropdown>
</template>