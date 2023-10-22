<script setup lang="ts">
import NumericInput from "@/resources/vue/Components/NumericInput.vue";
import TextAreaInput from "@/resources/vue/Components/TextAreaInput.vue";
import InputError from "@res/vue/Components/InputError.vue";
import InputLabel from "@res/vue/Components/InputLabel.vue";
import PrimaryButton from "@res/vue/Components/PrimaryButton.vue";
import SecondaryButton from "@res/vue/Components/SecondaryButton.vue";
import TextInput from "@res/vue/Components/TextInput.vue";
import { Identitas } from "@/resources/ts/types/data/sid/identitas";
import { readAsDataURL } from "@res/ts/helpers/file/reader";
import { useForm } from "@inertiajs/vue3";
import route from "ziggy-js";
import { ref } from "vue";

const { identitas } = defineProps<{ identitas: Identitas }>();

const form = useForm({ ...identitas, _method: 'patch' });

const logoPreview = ref<string>();
const logoInput = ref<HTMLInputElement>();

const stampPreview = ref<string>();
const stampInput = ref<HTMLInputElement>();

const updateIdentitas = () => {

    if (logoInput.value?.files) {
        form.logo = logoInput.value.files[0];
    }

    if (stampInput.value?.files) {
        form.stamp = stampInput.value.files[0];
    }

    form.post(route("dashboard.sid.identitas.update"), {
        errorBag: "updateIdentitas",
        preserveScroll: true,
    });
};

const selectNewLogo = () => {
    logoInput.value?.click();
}

const selectNewStamp = () => {
    stampInput.value?.click();
}

const updateLogoPreview = async () => {
    if (logoInput.value?.files) {
        logoPreview.value = await readAsDataURL(logoInput.value.files[0]);
    }
}

const updateStampPreview = async () => {
    if (stampInput.value?.files) {
        stampPreview.value = await readAsDataURL(stampInput.value.files[0]);
    }
};
</script>

<template>
    <form @submit.prevent="updateIdentitas">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:mt-0 md:col-span-1">
                <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
                    <!-- Profile Logo File Input -->
                    <input ref="logoInput" type="file" class="hidden" @change="updateLogoPreview" />

                    <!-- New Profile Logo Preview -->

                    <span class="block w-auto h-28 bg-cover bg-no-repeat bg-center" :style="'background-image: url(\'' + logoPreview + '\');'
                        " />

                    <SecondaryButton class="mt-5 mr-2 small" type="button" @click.prevent="selectNewLogo">
                        Select A New Logo
                    </SecondaryButton>

                    <InputError :message="form.errors.logo" class="mt-2" />
                </div>

                <div class="mt-6 px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
                    <!-- Profile Stamp File Input -->
                    <input ref="stampInput" type="file" class="hidden" @change="updateStampPreview" />

                    <!-- New Profile Stamp Preview -->

                    <span class="block w-auto h-28 bg-cover bg-no-repeat bg-center" :style="'background-image: url(\'' + stampPreview + '\');'
                        " />

                    <SecondaryButton class="mt-5 mr-2 small" type="button" @click.prevent="selectNewStamp">
                        Select A New Stamp
                    </SecondaryButton>

                    <InputError :message="form.errors.stamp" class="mt-2" />
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="nama_desa" value="Nama Desa" />
                            <TextInput id="nama_desa" v-model="form.nama_desa" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_desa" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="kode_desa" value="Kode Desa" />
                            <NumericInput id="kode_desa" v-model="form.kode_desa" type="number" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.kode_desa" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="nama_kades" value="Nama Kepala Desa" />
                            <TextInput id="nama_kades" v-model="form.nama_kades" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_kades" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="kodepos" value="Kode Pos" />
                            <NumericInput id="kodepos" v-model="form.kodepos" type="number" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.kodepos" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="telepon" value="Telepon Desa" />
                            <TextInput id="telepon" v-model="form.telepon" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.telepon" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="email" value="E-mail" />
                            <TextInput id="email" v-model="form.email" type="text" class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="website" value="Alamat Web" />
                            <TextInput id="website" v-model="form.website" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.website" class="mt-2" />
                        </div>

                        <div class="col-span-6">
                            <InputLabel for="alamat" value="Alamat Desa" />
                            <TextAreaInput id="alamat" v-model="form.alamat" type="text" class="block w-full mt-1" />
                            <InputError :message="form.errors.alamat" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <InputLabel for="lat" value="Latitude" />
                            <NumericInput id="lat" v-model="form.lat" type="text" class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.lat" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <InputLabel for="long" value="Longitude" />
                            <NumericInput id="long" v-model="form.long" type="text" class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.long" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_kecamatan" value="Nama Kecamatan" />
                            <TextInput id="nama_kecamatan" v-model="form.nama_kecamatan" type="text"
                                class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.nama_kecamatan" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_camat" value="Nama Camat" />
                            <TextInput id="nama_camat" v-model="form.nama_camat" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_camat" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="kode_kecamatan" value="Kode Kecamatan" />
                            <NumericInput id="kode_kecamatan" v-model="form.kode_kecamatan" type="text"
                                class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.kode_kecamatan" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_kabupaten" value="Nama Kabupaten" />
                            <TextInput id="nama_kabupaten" v-model="form.nama_kabupaten" type="text"
                                class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.nama_kabupaten" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_bupati" value="Nama Bupati" />
                            <TextInput id="nama_bupati" v-model="form.nama_bupati" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_bupati" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="kode_kabupaten" value="Kode Kabupaten" />
                            <NumericInput id="kode_kabupaten" v-model="form.kode_kabupaten" type="number"
                                class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.kode_kabupaten" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_provinsi" value="Nama Provinsi" />
                            <TextInput id="nama_provinsi" v-model="form.nama_provinsi" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_provinsi" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="nama_gubernur" value="Nama Gubernur" />
                            <TextInput id="nama_gubernur" v-model="form.nama_gubernur" type="text" class="block w-full mt-1"
                                autofocus />
                            <InputError :message="form.errors.nama_gubernur" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <InputLabel for="kode_provinsi" value="Kode Provinsi" />
                            <NumericInput id="kode_provinsi" v-model="form.kode_provinsi" type="number"
                                class="block w-full mt-1" autofocus />
                            <InputError :message="form.errors.kode_provinsi" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update
                    </PrimaryButton>
                </div>

            </div>
        </div>
    </form>
</template>
