<script setup>
import AppLayout from '@res/vue/Layouts/AppLayout.vue';
import CreateTeamForm from '@res/vue/Pages/Teams/Partials/CreateTeamForm.vue';
</script>

<template>
    <AppLayout title="Create Team">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateTeamForm />
            </div>
        </div>
    </AppLayout>
</template>
