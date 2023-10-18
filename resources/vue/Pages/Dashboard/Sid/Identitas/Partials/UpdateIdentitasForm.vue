<script setup lang="ts">
import { Identitas } from '@/resources/ts/types/data/sid/identitas';
import DropdownInput from '@/resources/vue/Components/DropdownInput.vue';
import NumericInput from '@/resources/vue/Components/NumericInput.vue';
import TextAreaInput from '@/resources/vue/Components/TextAreaInput.vue';
import { useForm } from '@inertiajs/vue3';
import FormSection from '@res/vue/Components/FormSection.vue';
import InputError from '@res/vue/Components/InputError.vue';
import InputLabel from '@res/vue/Components/InputLabel.vue';
import PrimaryButton from '@res/vue/Components/PrimaryButton.vue';
import TextInput from '@res/vue/Components/TextInput.vue';
import route from 'ziggy-js';

const { identitas } = defineProps<{ identitas: Identitas }>();

const form = useForm(identitas);

const updateIdentitas = () => {
    form.patch(route('dashboard.sid.identitas.update'), {
        errorBag: 'updateIdentitas',
        preserveScroll: true,
    });
};

</script>

<template>
    <FormSection @submitted="updateIdentitas">
        <template #title>
            Identitas Desa
        </template>

        <template #description>
            Informasi tentang desa yang akan ditampilkan system.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="nama_desa" value="Nama Desa" />
                <TextInput id="nama_desa" v-model="form.nama_desa" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.nama_desa" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="kode_desa" value="Kode Desa" />
                <NumericInput id="kode_desa" v-model="form.kode_desa" type="number" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.kode_desa" class="mt-2" />
            </div>

            <div class="col-span-6">
                <InputLabel for="alamat" value="Alamat Desa" />
                <TextAreaInput id="alamat" v-model="form.alamat" type="text" class="block w-full mt-1" />
                <InputError :message="form.errors.alamat" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </PrimaryButton>
        </template>
    </FormSection>
</template>
