<script setup>
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import CreateCategoryForm from './Partials/CreateCategoryForm.vue'
import AppLayout from '@/resources/vue/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Create Category">
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Create New Category
            </h2>
        </template>
        <JetBarContainer>
            <CreateCategoryForm />
        </JetBarContainer>
    </AppLayout>
</template>
