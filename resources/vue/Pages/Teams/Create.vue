<script setup>
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';
import CreateTeamForm from '@res/vue/Pages/Teams/Partials/CreateTeamForm.vue';
</script>

<template>
    <JetBarLayout title="Create Team">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateTeamForm />
            </div>
        </div>
    </JetBarLayout>
</template>
