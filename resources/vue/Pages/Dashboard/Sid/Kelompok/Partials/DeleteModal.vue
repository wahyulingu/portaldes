<template>
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
</template>

<script setup lang="ts">
import route from "ziggy-js";
import { useForm } from "@inertiajs/vue3";
import { Category } from "@/resources/ts/types/data/category";
import ConfirmationModal from "@/resources/vue/Components/ConfirmationModal.vue";
import SecondaryButton from "@/resources/vue/Components/SecondaryButton.vue";
import DangerButton from "@/resources/vue/Components/DangerButton.vue";

const deleteCategoryForm = useForm({});

let { categoryBeingDeleted } = defineProps<{ categoryBeingDeleted: null | Category }>();

const deleteCategory = () => {
    if (categoryBeingDeleted) {
        deleteCategoryForm.delete(
            route(
                "dashboard.content.category.destroy",
                categoryBeingDeleted
            ),
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => (categoryBeingDeleted = null),
            }
        );
    }
};
</script>