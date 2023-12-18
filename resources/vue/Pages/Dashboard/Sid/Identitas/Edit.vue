<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import AppLayout from '@res/vue/Layouts/AppLayout.vue';
import UpdateIdentitasForm from './Partials/Edit/Form.vue'
import { Identitas } from '@/resources/ts/types/data/sid/identitas'

const { identitas } = defineProps<{ identitas: Identitas }>();

</script>

<template>
    <AppLayout title="Update Identitas">
        <JetBarContainer>
            <UpdateIdentitasForm :identitas="identitas" />
        </JetBarContainer>
    </AppLayout>
</template>



