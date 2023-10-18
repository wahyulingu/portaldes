<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';
import UpdateIdentitasForm from './Partials/UpdateIdentitasForm.vue';
import { Identitas } from '@/resources/ts/types/data/sid/identitas';

const { identitas } = defineProps<{ identitas: Identitas }>();
</script>

<template>
    <JetBarLayout title="Update Identitas">
        <JetBarContainer>
            <UpdateIdentitasForm :identitas="identitas"/>
        </JetBarContainer>
    </JetBarLayout>
</template>
