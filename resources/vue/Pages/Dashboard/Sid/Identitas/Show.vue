<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import AppLayout from '@res/vue/Layouts/AppLayout.vue';
import { Identitas } from '@res/ts/types/data/sid/identitas'

defineProps<{ identitas: Identitas }>();
</script>

<template>
    <AppLayout :title="'Identitas Desa'">
        <JetBarContainer>

            {{ JSON.stringify(identitas) }}

        </JetBarContainer>
    </AppLayout>
</template>
