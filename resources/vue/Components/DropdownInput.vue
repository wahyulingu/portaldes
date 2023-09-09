<script setup lang="ts">
import { computed } from 'vue';
import Dropdown from './Dropdown.vue';

interface PropsType {
    modelValue: string,
    options: Array<{
        title: string,
        value: string
    }>
}

const props = defineProps<PropsType>();

const emit = defineEmits(['update:modelValue']);

const selected = computed(() => props.options.find(option => {
    if (option.value == props.modelValue) {
        return option;
    }
}));

function emitValue(value: string) {
    emit('update:modelValue', value)
}
</script>

<template>
    <Dropdown align="left"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
        <template #trigger>
            <button class="block w-full" type="button">
                <div class="flex justify-between">
                    <div class="flex items-center justify-start">
                        {{ selected?.title }}
                    </div>
                    <svg class="mt-1 ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </div>
            </button>
        </template>
        <template #content>
            <template v-for="option in options">
                <button type="button" @click="emitValue(option.value)"
                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                    {{ option.title }}
                </button>
            </template>
        </template>
    </Dropdown>
</template>
