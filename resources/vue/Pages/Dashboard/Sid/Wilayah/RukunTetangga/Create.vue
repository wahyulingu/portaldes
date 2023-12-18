<script setup>
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import AppLayout from '@res/vue/Layouts/AppLayout.vue';
import CreateCategoryForm from './Partials/CreateCategoryForm.vue'
</script>

<template>
    <AppLayout title="Create Category">
        <JetBarContainer>
            <CreateCategoryForm />
        </JetBarContainer>
    </AppLayout>
</template>
