<script setup lang="ts">
import JetBarContainer from '@/resources/vue/Components/JetBar/JetBarContainer.vue';
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue';

defineProps<{ identitas: Object }>();
</script>

<template>
    <JetBarLayout :title="'Identitas '">
        <JetBarContainer>
            <h2>
                Yooos!
            </h2>
            <code>

            {{ JSON.stringify(identitas) }}
            </code>
        </JetBarContainer>
    </JetBarLayout>
</template>
