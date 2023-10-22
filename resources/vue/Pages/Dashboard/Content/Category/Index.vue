<template>
    <JetBarLayout title="Content Category">
        <JetBarContainer>
            <JetBarTable>
                <template #pagination>
                    <JetBarSimplePagination :items="categories" />
                </template>
                <template #head>
                    <JetBarTableHead :headers="['Name', 'Description', 'Status', '']">
                        <template #button>
                            <Link
                                :href="route('dashboard.content.category.create')"
                                class="text-blue-500 hover:text-blue-600 uppercase">
                                + Baru
                            </Link>
                        </template>
                    </JetBarTableHead>
                </template>
                <template v-for="category in categories.data">
                    <tr class="hover:bg-gray-50">
                        <JetBarTableData>{{ category.name }}</JetBarTableData>
                        <JetBarTableData>
                            <div class="text-sm text-gray-900">
                                {{ category.description }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ category.articles_count }} Articles |
                                {{ category.pages_count }} Pages |
                                {{ category.childs_count }} Childs
                            </div>
                        </JetBarTableData>
                        <JetBarTableData>
                            <JetBarBadge text="Active" type="success" />
                        </JetBarTableData>
                        <JetBarTableData>
                            <Link
                                href="#"
                                class="text-gray-400 hover:text-gray-500"
                            >
                                <JetBarIcon type="eye" fill />
                            </Link>
                        </JetBarTableData>
                    </tr>
                </template>
            </JetBarTable>
        </JetBarContainer>
    </JetBarLayout>
</template>

<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import JetBarLayout from "@res/vue/Layouts/JetBarLayout.vue";
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

defineProps<{
    categories: Paginate<Category>;
}>();
</script>
