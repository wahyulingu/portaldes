<template>
    <nav
        class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
        <div
            class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
            <!-- Toggler -->
            <button
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Brand -->
            <Link
                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                href="/">
            Vue Notus
            </Link>
            <!-- User -->
            <ul class="md:hidden items-center flex flex-wrap list-none">
                <li class="inline-block relative">
                    <notification-dropdown />
                </li>
                <li class="inline-block relative">
                    <user-dropdown />
                </li>
            </ul>
            <!-- Collapse -->
            <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
                v-bind:class="collapseShow">
                <!-- Collapse header -->
                <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-slate-200">
                    <div class="flex flex-wrap">
                        <div class="w-6/12">
                            <Link
                                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                                href="/">
                            Vue Notus
                            </Link>
                        </div>
                        <div class="w-6/12 flex justify-end">
                            <button type="button"
                                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                                v-on:click="toggleCollapseShow('hidden')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <form class="mt-6 mb-4 md:hidden">
                    <div class="mb-3 pt-0">
                        <input type="text" placeholder="Search"
                            class=" px-3 py-2 h-12 border border-solid border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
                    </div>
                </form>

                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    Admin Layout Pages
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <li class="items-center">
                        <Link href="/admin/dashboard">
                        <a :href="href" @click="navigate" class="text-xs uppercase py-3 font-bold block" :class="[
                            isActive
                                ? 'text-emerald-500 hover:text-emerald-600'
                                : 'text-slate-700 hover:text-slate-500',
                        ]">
                            <i class="fas fa-tv mr-2 text-sm" :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
                            Dashboard
                        </a>
                        </Link>
                    </li>

                    <li class="items-center">
                        <Link href="/admin/settings">
                        <a :href="href" @click="navigate" class="text-xs uppercase py-3 font-bold block" :class="[
                            isActive
                                ? 'text-emerald-500 hover:text-emerald-600'
                                : 'text-slate-700 hover:text-slate-500',
                        ]">
                            <i class="fas fa-tools mr-2 text-sm" :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
                            Settings
                        </a>
                        </Link>
                    </li>

                    <li class="items-center">
                        <Link href="/admin/tables">
                        <a :href="href" @click="navigate" class="text-xs uppercase py-3 font-bold block" :class="[
                            isActive
                                ? 'text-emerald-500 hover:text-emerald-600'
                                : 'text-slate-700 hover:text-slate-500',
                        ]">
                            <i class="fas fa-table mr-2 text-sm" :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
                            Tables
                        </a>
                        </Link>
                    </li>

                    <li class="items-center">
                        <Link href="/admin/maps">
                        <a :href="href" @click="navigate" class="text-xs uppercase py-3 font-bold block" :class="[
                            isActive
                                ? 'text-emerald-500 hover:text-emerald-600'
                                : 'text-slate-700 hover:text-slate-500',
                        ]">
                            <i class="fas fa-map-marked mr-2 text-sm"
                                :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
                            Maps
                        </a>
                        </Link>
                    </li>
                </ul>

                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    Auth Layout Pages
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                    <li class="items-center">
                        <Link class="text-slate-700 hover:text-slate-500 text-xs uppercase py-3 font-bold block"
                            href="/auth/login">
                        <i class="fas fa-fingerprint text-slate-300 mr-2 text-sm"></i>
                        Login
                        </Link>
                    </li>

                    <li class="items-center">
                        <Link class="text-slate-700 hover:text-slate-500 text-xs uppercase py-3 font-bold block"
                            href="/auth/register">
                        <i class="fas fa-clipboard-list text-slate-300 mr-2 text-sm"></i>
                        Register
                        </Link>
                    </li>
                </ul>

                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    No Layout Pages
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                    <li class="items-center">
                        <Link class="text-slate-700 hover:text-slate-500 text-xs uppercase py-3 font-bold block"
                            href="/landing">
                        <i class="fas fa-newspaper text-slate-300 mr-2 text-sm"></i>
                        Landing Page
                        </Link>
                    </li>

                    <li class="items-center">
                        <Link class="text-slate-700 hover:text-slate-500 text-xs uppercase py-3 font-bold block"
                            href="/profile">
                        <i class="fas fa-user-circle text-slate-300 mr-2 text-sm"></i>
                        Profile Page
                        </Link>
                    </li>
                </ul>

                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6 class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
                    Documentation
                </h6>
                <!-- Navigation -->
                <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/vue/colors/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fas fa-paint-brush mr-2 text-slate-300 text-base"></i>
                            Styles
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/vue/alerts/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-css3-alt mr-2 text-slate-300 text-base"></i>
                            CSS Components
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/angular/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-angular mr-2 text-slate-300 text-base"></i>
                            Angular
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/js/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-js-square mr-2 text-slate-300 text-base"></i>
                            Javascript
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/nextjs/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-react mr-2 text-slate-300 text-base"></i>
                            NextJS
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/react/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-react mr-2 text-slate-300 text-base"></i>
                            React
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/svelte/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fas fa-link mr-2 text-slate-300 text-base"></i>
                            Svelte
                        </a>
                    </li>

                    <li class="inline-flex">
                        <a href="https://www.creative-tim.com/learning-lab/tailwind/vue/overview/notus" target="_blank"
                            class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                            <i class="fab fa-vuejs mr-2 text-slate-300 text-base"></i>
                            VueJS
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>


<script setup>
import NotificationDropdown from "@res/vue/Components/Notus/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@res/vue/Components/Notus/Dropdowns/UserDropdown.vue";
import { ref } from 'vue'

import { Link } from '@inertiajs/vue3';


const collapseShow = ref("hidden")

const toggleCollapseShow = function (classes) {
    this.collapseShow = classes;
}
</script>
