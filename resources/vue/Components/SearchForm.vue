<template>
    <form class="flex items-center ml-6" @submit.prevent="find">
        <!-- Teams Dropdown -->

        <TextInput id="keyword" v-model="form.keyword" placeholder="Keyword..." type="text"
            class="inline-flex relative text text-start w-full mt-1 py-1" autofocus />

        <NumericInput id="keyword" v-model="form.limit" placeholder="Limit" type="number"
            class="inline-flex relative text text-start w-20 ml-1 mt-1 py-1" />

        <PrimaryButton class="mt-1 py-1 ml-1 focus:ring-offset-0" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing">
            Ok
        </PrimaryButton>
        <SecondaryButton class="mt-1 py-1 ml-1 focus:ring-offset-0" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" title="Reset Keyword" @click="resetKeyword">
            X
        </SecondaryButton>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import route from 'ziggy-js';
import TextInput from './TextInput.vue';
import NumericInput from './NumericInput.vue';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';

const props = defineProps<{
    action: string;
    query: {
        keyword: string,
        limit: number
    };
}>();

const form = useForm({
    keyword: props.query.keyword,
    limit: props.query.limit
});

function find() {
    return form.get(route(props.action), {
        preserveScroll: true,
    });
};

function resetKeyword() {
    form.keyword = ''

    return find();
}
</script>