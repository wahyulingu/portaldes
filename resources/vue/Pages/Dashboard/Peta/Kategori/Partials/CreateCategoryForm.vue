<script setup>
import DropdownInput from '@/resources/vue/Components/DropdownInput.vue';
import TextAreaInput from '@/resources/vue/Components/TextAreaInput.vue';
import { useForm } from '@inertiajs/vue3';
import FormSection from '@res/vue/Components/FormSection.vue';
import InputError from '@res/vue/Components/InputError.vue';
import InputLabel from '@res/vue/Components/InputLabel.vue';
import PrimaryButton from '@res/vue/Components/PrimaryButton.vue';
import TextInput from '@res/vue/Components/TextInput.vue';

const form = useForm({
    name: '',
    description: '',
    status: 'active',
});

const createCategory = () => {
    form.post(route('dashboard.content.category.store'), {
        errorBag: 'createCategory',
        preserveScroll: true,
    });
};

</script>

<template>
    <FormSection @submitted="createCategory">
        <template #title>
            Category Details
        </template>

        <template #description>
            Create a new category to organize web content.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Category Name" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="status" value="Category Status" />
                <DropdownInput :options="[
                    {
                        title: 'Active',
                        value: 'active'
                    },
                    {
                        title: 'Inactive',
                        value: 'incative'
                    }
                ]" id="status" v-model="form.status" type="text" class="block w-full mt-1" />
                <InputError :message="form.errors.status" class="mt-2" />
            </div>

            <div class="col-span-6">
                <InputLabel for="description" value="Category Description" />
                <TextAreaInput id="description" v-model="form.description" type="text" class="block w-full mt-1" />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>
