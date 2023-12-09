<script setup>
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';
import CreateCategoryForm from './Partials/CreateCategoryForm.vue'
</script>

<template>
    <JetBarLayout title="Create Category">
        <JetBarContainer>
            <CreateCategoryForm />
        </JetBarContainer>
    </JetBarLayout>
</template>
