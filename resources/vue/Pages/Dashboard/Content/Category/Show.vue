<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';
import { Category } from '@/resources/ts/types/data/category';

defineProps<{ category: Category }>();
</script>

<template>
    <JetBarLayout :title="'Category ' + category.name">
        <JetBarContainer>
            {{ JSON.stringify(category) }}
        </JetBarContainer>
    </JetBarLayout>
</template>
