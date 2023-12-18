<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import AppLayout from '@res/vue/Layouts/AppLayout.vue';
import { Category } from '@/resources/ts/types/data/category';

defineProps<{ category: Category }>();
</script>

<template>
    <AppLayout :title="'Category ' + category.name">
        <JetBarContainer>
            {{ JSON.stringify(category) }}
        </JetBarContainer>
    </AppLayout>
</template>
