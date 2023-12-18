<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-white text-sm uppercase hidden lg:inline-block font-semibold">
                Dashboard
            </h2>
        </template>
        <div>
            <div class="flex flex-wrap">
                <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                    <card-social-traffic />
                </div>
                <div class="w-full xl:w-4/12 px-4">
                    <card-social-traffic />
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                    <card-social-traffic />
                </div>
                <div class="w-full xl:w-4/12 px-4">
                    <card-social-traffic />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@res/vue/Layouts/AppLayout.vue'
import CardSocialTraffic from '@res/vue/Components/Notus/Cards/CardSocialTraffic.vue';
</script>
