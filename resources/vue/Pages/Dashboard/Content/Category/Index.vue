<template>
    <AppLayout title="Content Category">
        <template #header>
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Manage Content Category
            </h2>
        </template>
        <JetBarContainer>
            <div class="flex justify-between mb-2">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-2 sm:-my-px sm:flex">
                        <span
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div class="relative text text-start">
                                <div>
                                    <button type="button" class="inline-flex items-center">
                                        Semua
                                    </button>
                                </div>
                            </div>
                        </span>
                        <span
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div class="relative text text-start">
                                <div>
                                    <button type="button" class="inline-flex items-center">
                                        Aktif
                                    </button>
                                </div>
                            </div>
                        </span>
                        <span
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div class="relative text text-start">
                                <div>
                                    <button type="button" class="inline-flex items-center">
                                        Tidak Aktif
                                    </button>
                                </div>
                            </div>
                        </span>
                        <span
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div class="relative text text-start">
                                <div>
                                    <Link :href="route('dashboard.content.category.create')"
                                        class="inline-flex items-center">
                                    Buat Baru
                                    </Link>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                <SearchForm action="dashboard.content.category.index" :query="query" />
                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                            <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <JetBarTable>
                <template #pagination>
                    <JetBarSimplePagination :items="categories" />
                </template>
                <template #head>
                    <JetBarTableHead :headers="[
                        '#',
                        'Status',
                        'Action',
                        'Category',
                        'Articles',
                        'Pages',
                    ]" />
                </template>
                <template v-for="category in categories.data">
                    <tr class="hover:bg-gray-50">
                        <JetBarTableData> * </JetBarTableData>
                        <JetBarTableData>
                            <JetBarBadge text="Active" type="success" />
                        </JetBarTableData>
                        <JetBarTableData>
                            <div class="flex items-center gap-2">
                                <button class="inline-flex" title="Inactive">
                                    <JetBarIcon type="x-circle" class="inline-flex" fill />
                                </button>
                                <button class="inline-flex" title="Show">
                                    <JetBarIcon type="eye" class="inline-flex" fill />
                                </button>
                                <button class="inline-flex" title="Edit">
                                    <JetBarIcon type="pencil-alt" class="inline-flex" fill />
                                </button>
                                <button class="inline-flex" title="Delete">
                                    <JetBarIcon type="trash" class="inline-flex" fill />
                                </button>
                            </div>
                        </JetBarTableData>
                        <JetBarTableData class="w-full">
                            <div class="text-sm text-gray-900">
                                {{ category.name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ category.description }}
                            </div>
                        </JetBarTableData>
                        <JetBarTableData>
                            {{ category.articles_count }}
                        </JetBarTableData>
                        <JetBarTableData>
                            {{ category.pages_count }}
                        </JetBarTableData>
                    </tr>
                </template>
            </JetBarTable>
        </JetBarContainer>
    </AppLayout>
</template>

<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@res/vue/Layouts/AppLayout.vue";
import JetBarContainer from "@res/vue/Components/JetBar/JetBarContainer.vue";
import JetBarTable from "@res/vue/Components/JetBar/JetBarTable.vue";
import JetBarTableData from "@res/vue/Components/JetBar/JetBarTableData.vue";
import JetBarBadge from "@res/vue/Components/JetBar/JetBarBadge.vue";
import JetBarIcon from "@res/vue/Components/JetBar/JetBarIcon.vue";
import { Category } from "@/resources/ts/types/data/category";
import { Paginate } from "@/resources/ts/types/data/pagination/paginate";
import JetBarTableHead from "@/resources/vue/Components/JetBar/JetBarTableHead.vue";
import JetBarSimplePagination from "@/resources/vue/Components/JetBar/JetBarSimplePagination.vue";
import route from "ziggy-js";
import TextInput from "@/resources/vue/Components/TextInput.vue";
import PrimaryButton from "@/resources/vue/Components/PrimaryButton.vue";
import SecondaryButton from "@/resources/vue/Components/SecondaryButton.vue";
import NumericInput from "@/resources/vue/Components/NumericInput.vue";
import SearchForm from "@/resources/vue/Components/SearchForm.vue";

defineProps<{
    categories: Paginate<Category>;
    query: {
        keyword: string,
        limit: number
    };
}>();
</script>
