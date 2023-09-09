<template>
    <Head :title="title" />
    <div class="font-sans antialiased bg-gray-100">
        <JetBanner />

        <div class="lg:flex flex-col lg:flex-row lg:min-h-screen w-full">

            <!-- Sidebar -->
            <JetBarSidebar />
            <!-- End Sidebar -->

            <div class="w-full">

                <!-- Top Navbar -->
                <JetBarNavigationMenu />
                <!-- End Top Navbar -->

                <!-- Content Container -->
                <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
                    <div class="max-w-7xl mx-auto pt-3 px-4 sm:px-6 lg:px-8">
                        <!-- Title -->
                        <template v-if="hasRightButton">
                            <div class="flex flex-wrap items-center">

                                <div class="relative w-full max-w-full flex-grow flex-1">

                                    <h1
                                        class="text-lg font-semibold tracking-widest text-gray-900 uppercase dark-mode:text-white">
                                        {{ title }}</h1>
                                </div>

                                <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                                    <slot name="rightButton" />
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <h1 class="text-lg font-semibold tracking-widest text-gray-900 uppercase dark-mode:text-white">
                                {{ title }}
                            </h1>
                        </template>

                        <!-- End Title -->
                    </div>
                    <!-- Content -->
                    <slot />
                    <!-- End Content -->
                </main>
                <!-- Content Container -->
            </div>
        </div>
    </div>
</template>

<script setup>
import JetBanner from '@res/vue/Components/Banner.vue'
import JetBarNavigationMenu from '@res/vue/Components/JetBar/JetBarNavigationMenu.vue'
import JetBarSidebar from '@res/vue/Components/JetBar/JetBarSidebar.vue'
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useSlots } from 'vue';

const slots = useSlots()

const hasRightButton = computed(() => !!slots.rightButton)

defineProps({ title: String });

</script>
