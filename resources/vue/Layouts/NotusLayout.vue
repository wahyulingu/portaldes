<template>
    <div>
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
                                class="px-3 py-2 h-12 border border-solid border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
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
                                <i class="fas fa-tools mr-2 text-sm"
                                    :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
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
                                <i class="fas fa-table mr-2 text-sm"
                                    :class="[isActive ? 'opacity-75' : 'text-slate-300']"></i>
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
                            <a href="https://www.creative-tim.com/learning-lab/tailwind/angular/overview/notus"
                                target="_blank"
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
                            <a href="https://www.creative-tim.com/learning-lab/tailwind/nextjs/overview/notus"
                                target="_blank"
                                class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                                <i class="fab fa-react mr-2 text-slate-300 text-base"></i>
                                NextJS
                            </a>
                        </li>

                        <li class="inline-flex">
                            <a href="https://www.creative-tim.com/learning-lab/tailwind/react/overview/notus"
                                target="_blank"
                                class="text-slate-700 hover:text-slate-500 text-sm block mb-4 no-underline font-semibold">
                                <i class="fab fa-react mr-2 text-slate-300 text-base"></i>
                                React
                            </a>
                        </li>

                        <li class="inline-flex">
                            <a href="https://www.creative-tim.com/learning-lab/tailwind/svelte/overview/notus"
                                target="_blank"
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
        <div class="relative md:ml-64 bg-blueGray-100">
            <!-- Navbar -->
            <header
                class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
                <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
                    <!-- Brand -->
                    <h2 class="text-white text-sm uppercase hidden lg:inline-block font-semibold">
                        {{ title }}
                    </h2>
                    <!-- Form -->
                    <form class="md:flex hidden flex-row flex-wrap items-center lg:ml-auto mr-3">
                        <div class="relative flex w-full flex-wrap items-stretch">
                            <span
                                class="z-10 h-full leading-snug font-normal absolute text-center text-slate-300 bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" placeholder="Search here..."
                                class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10" />
                        </div>
                    </form>
                    <!-- User -->
                    <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                        <Dropdown align="right" width="60">
                            <template #trigger>
                                <button v-if="$page.props.jetstream.managesProfilePhotos"
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-11 w-11 rounded-full object-cover"
                                        :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                </button>

                                <span v-else class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ $page.props.auth.user.name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <div class="w-60">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                        :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams"
                                            :href="route('teams.create')">
                                            Create New Team
                                        </DropdownLink>


                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Switch Teams
                                        </div>

                                        <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                            <form @submit.prevent="switchToTeam(team)">
                                                <DropdownLink as="button">
                                                    <div class="flex items-center">
                                                        <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                            class="mr-2 h-5 w-5 text-green-400"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>

                                                        <div>{{ team.name }}</div>
                                                    </div>
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </template>

                                    <div class="border-t border-gray-200 dark:border-gray-600" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </div>
                            </template>
                        </Dropdown>
                    </ul>
                </div>
            </header>
            <div class="px-4 md:px-10 mx-auto w-full">
                <main>
                    <slot />
                </main>
                <footer class="block py-4">
                    <div class="container mx-auto px-4">
                        <hr class="mb-4 border-b-1 border-slate-200" />
                        <div class="flex flex-wrap items-center md:justify-between justify-center">
                            <div class="w-full md:w-4/12 px-4">
                                <div class="text-sm text-slate-500 font-semibold py-1 text-center md:text-left">
                                    Copyright © {{ date }}
                                    <a href="https://www.creative-tim.com?ref=vn-footer-admin"
                                        class="text-slate-500 hover:text-slate-700 text-sm font-semibold py-1">
                                        Creative Tim
                                    </a>
                                </div>
                            </div>
                            <div class="w-full md:w-8/12 px-4">
                                <ul class="flex flex-wrap list-none md:justify-end justify-center">
                                    <li>
                                        <a href="https://www.creative-tim.com?ref=vn-footer-admin"
                                            class="text-slate-600 hover:text-slate-800 text-sm font-semibold block py-1 px-3">
                                            Creative Tim
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.creative-tim.com/presentation?ref=vn-footer-admin"
                                            class="text-slate-600 hover:text-slate-800 text-sm font-semibold block py-1 px-3">
                                            About Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://blog.creative-tim.com?ref=vn-footer-admin"
                                            class="text-slate-600 hover:text-slate-800 text-sm font-semibold block py-1 px-3">
                                            Blog
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://github.com/creativetimofficial/vue-notus/blob/main/LICENSE.md?ref=vn-footer-admin"
                                            class="text-slate-600 hover:text-slate-800 text-sm font-semibold block py-1 px-3">
                                            MIT License
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <Head :title="title" />
    </div>
</template>
<script setup>
import Dropdown from '@res/vue/Components/Dropdown.vue';
import DropdownLink from '@res/vue/Components/DropdownLink.vue';
import HeaderStats from "@res/vue/Components/Notus/Headers/HeaderStats.vue";
import { Head, Link, router } from '@inertiajs/vue3';
import NotificationDropdown from "@res/vue/Components/Notus/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@res/vue/Components/Notus/Dropdowns/UserDropdown.vue";
import { ref } from 'vue'

const collapseShow = ref("hidden")

const toggleCollapseShow = function (classes) {
    this.collapseShow = classes;
}

defineProps({
    title: String,
});

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const date = new Date().getFullYear()
</script>
  