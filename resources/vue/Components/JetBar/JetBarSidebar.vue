<template>
    <div
        class="flex flex-col w-full lg:w-64 text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0 lg:border-r">
        <div class="flex-shrink-0 px-4 lg:px-8 py-4 flex flex-row items-center justify-between">
            <!-- App Title -->
            <Link :href="route('dashboard')"
                class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
            <ApplicationMark class="block h-9 w-auto" />
            </Link>
            <!-- End App Title -->
            <button class="rounded-lg lg:hidden focus:outline-none focus:shadow-outline"
                @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path v-show="!showingNavigationDropdown" fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                    <path v-show="showingNavigationDropdown" fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div v-show="showingNavigationDropdown" @click="showingNavigationDropdown = false"
            class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>
        <!-- Sidebar Links -->
        <nav :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="flex-grow lg:block px-4 pb-4 lg:pb-0 lg:overflow-y-auto z-10">

            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Content">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.category.index')">
                    Category
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.comment.index')">
                    Comment
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.page.index')">
                    Page
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>
            <SidebarDropdown icon="globe" title="Article">
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
                <DropdownLink :href="route('dashboard.content.article.index')">
                    Manage Article
                </DropdownLink>
            </SidebarDropdown>

            <template v-if="$page.props.jetstream.hasTeamFeatures">
                <Link v-if="$page.props.jetstream.canCreateTeams"
                    :class="route().current('teams.create') ? 'bg-gray-200' : 'bg-transparent'"
                    class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    :href="route('teams.create')">Create Team</Link>
                <Link :class="route().current('teams.show') ? 'bg-gray-200' : 'bg-transparent'"
                    class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    :href="route('teams.show', $page.props.auth.user.current_team)">Team Settings</Link>
            </template>
            <Link :class="route().current('profile.show') ? 'bg-gray-200' : 'bg-transparent'"
                class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                :href="route('profile.show')">Profile</Link>

            <JetBarResponsiveLinks />

        </nav>
        <div v-show="showingSidebarNavigationDropdown" @click="showingSidebarNavigationDropdown = false"
            class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>
        <!-- End Sidebar Links -->
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import JetBarResponsiveLinks from '@res/vue/Components/JetBar/JetBarResponsiveLinks.vue'
import { ref } from 'vue';
import ApplicationMark from '../ApplicationMark.vue';
import SidebarDropdown from '../Lingu/SidebarDropdown.vue';
import DropdownLink from '../DropdownLink.vue';

const showingNavigationDropdown = ref(false)
const showingSidebarNavigationDropdown = ref(false)
</script>
