<template>
    <NotusLayout title="Category">
        <template #rightButton>
            <Link :href="route('dashboard.content.category.create')"
                class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold p-1 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                type="button">
            + Baru
            </Link>
        </template>
        <JetBarContainer>
            <JetBarTable>
                <template #pagination>
                    <JetBarSimplePagination :items="categories" />
                </template>
                <template #head>
                    <JetBarTableHead :headers="['name', 'status', '', '', '', '']" />
                </template>
                <template v-for="category in categories.data">
                    <tr class="hover:bg-gray-50">
                        <JetBarTableData>
                            <div class="text-sm text-gray-900 whitespace-nowrap">
                                {{ category.name }}
                            </div>
                            {{ limit(category.description, 64) }}
                        </JetBarTableData>
                        <JetBarTableData>
                            <JetBarBadge :text="category.status" :type="statusType(category.status)" />
                        </JetBarTableData>
                        <JetBarTableData>
                            <Link :href="route('dashboard.content.category.show', category)"
                                class="text-gray-400 hover:text-gray-500">
                            <JetBarIcon type="pencil" fill />
                            </Link>
                        </JetBarTableData>
                        <JetBarTableData>
                            <button class="text-gray-400 hover:text-gray-500" @click="confirmCategoryDeletion(category)">
                                <JetBarIcon type="trash" fill />
                            </button>
                        </JetBarTableData>
                        <JetBarTableData>
                            <Link :href="route(
                                'dashboard.content.category.show',
                                category
                            )
                                " class="text-gray-400 hover:text-gray-500">
                            <JetBarIcon type="pencil" fill />
                            </Link>
                        </JetBarTableData>
                        <JetBarTableData>
                            <button class="text-gray-400 hover:text-gray-500" @click="confirmCategoryDeletion(category)">
                                <JetBarIcon type="trash" fill />
                            </button>
                        </JetBarTableData>
                    </tr>
                </template>
            </JetBarTable>
        </JetBarContainer>

        <ConfirmationModal :show="categoryBeingDeleted != null" @close="categoryBeingDeleted = null">
            <template #title> Delete Category </template>

            <template #content>
                Are you sure you would like to delete "{{
                    categoryBeingDeleted?.name
                }}" category?
            </template>

            <template #footer>
                <SecondaryButton @click="categoryBeingDeleted = null">
                    Cancel
                </SecondaryButton>

                <DangerButton class="ml-3" :class="{ 'opacity-25': deleteCategoryForm.processing }"
                    :disabled="deleteCategoryForm.processing" @click="deleteCategory">
                    Delete
                </DangerButton>
            </template>
        </ConfirmationModal>
    </NotusLayout>
</template>

<script setup lang="ts">
import route from "ziggy-js";
import { Link, useForm } from "@inertiajs/vue3";
import NotusLayout from "@res/vue/Layouts/NotusLayout.vue";
import JetBarContainer from "@res/vue/Components/JetBar/JetBarContainer.vue";
import { Category } from "@/resources/ts/types/data/category";
import { limit, statusType } from "@res/ts/helpers/string";
import JetBarTable from "@res/vue/Components/JetBar/JetBarTable.vue";
import JetBarTableData from "@res/vue/Components/JetBar/JetBarTableData.vue";
import JetBarBadge from "@res/vue/Components/JetBar/JetBarBadge.vue";
import JetBarIcon from "@res/vue/Components/JetBar/JetBarIcon.vue";
import JetBarTableHead from "@/resources/vue/Components/JetBar/JetBarTableHead.vue";
import JetBarSimplePagination from "@/resources/vue/Components/JetBar/JetBarSimplePagination.vue";
import ConfirmationModal from "@/resources/vue/Components/ConfirmationModal.vue";
import SecondaryButton from "@/resources/vue/Components/SecondaryButton.vue";
import DangerButton from "@/resources/vue/Components/DangerButton.vue";
import { ref } from "vue";

const deleteCategoryForm = useForm({});

const categoryBeingDeleted = ref<null | Category>(null);

const confirmCategoryDeletion = (category: null | Category) => {
    categoryBeingDeleted.value = category;
};

const deleteCategory = () => {
    if (categoryBeingDeleted.value) {
        deleteCategoryForm.delete(
            route(
                "dashboard.content.category.destroy",
                categoryBeingDeleted.value
            ),
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => (categoryBeingDeleted.value = null),
            }
        );
    }
};

defineProps<{ categories: { data: Array<Category> } }>();
</script>
