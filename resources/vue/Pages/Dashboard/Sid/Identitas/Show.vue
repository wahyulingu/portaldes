<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';
import { Identitas } from '@res/ts/types/data/sid/identitas'

defineProps<{ identitas: Identitas }>();
</script>

<template>
    <JetBarLayout :title="'Identitas Desa'">
        <JetBarContainer>

            {{ JSON.stringify(identitas) }}
            
        </JetBarContainer>
    </JetBarLayout>
</template>
