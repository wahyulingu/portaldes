<script setup>
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import CreateCategoryForm from './Partials/CreateCategoryForm.vue'
import AppLayout from '@/resources/vue/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Create Category">
        <JetBarContainer>
            <CreateCategoryForm />
        </JetBarContainer>
    </AppLayout>
</template>
