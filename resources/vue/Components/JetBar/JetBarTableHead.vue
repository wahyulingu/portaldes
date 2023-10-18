<template>
    <tr>
        <template v-for="(header, index) in headers">
            <template v-if="hasButton && index == 0">
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            {{ header }}
                        </div>
                        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                            <slot name="button"/>
                        </div>
                    </div>
                </th>
            </template>
            <template v-else>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ header }}
                </th>
            </template>
        </template>
    </tr>
</template>

<script setup>
import { computed, useSlots } from 'vue';

const slots = useSlots()

const hasButton = computed(() => !!slots.button)

defineProps({ headers: Array })
</script>

