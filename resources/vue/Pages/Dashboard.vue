<template>
    <AppLayout title="Dashboard">
        <JetBarContainer>
            <JetBarStatsContainer>
                <JetBarStatCard title="Total clients" number="6389" type="warning">
                    <template v-slot:icon>
                        <JetBarIcon type="users" fill />
                    </template>
                </JetBarStatCard>

                <JetBarStatCard title="Account balance" number="$ 46,760.89" type="success">
                    <template v-slot:icon>
                        <JetBarIcon type="money" fill />
                    </template>
                </JetBarStatCard>

                <JetBarStatCard title="New sales" number="376" type="info">
                    <template v-slot:icon>
                        <JetBarIcon type="cart" fill />
                    </template>
                </JetBarStatCard>

                <JetBarStatCard title="Pending contacts" number="35" type="danger">
                    <template v-slot:icon>
                        <JetBarIcon type="message" fill />
                    </template>
                </JetBarStatCard>
            </JetBarStatsContainer>

            <JetBarTable :headers="['name', 'title', 'status', 'role', '', '']">
                <tr class="hover:bg-gray-50" v-for="index in 3" :key="index">
                    <JetBarTableData>Jane Cooper</JetBarTableData>
                    <JetBarTableData>
                        <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                        <div class="text-sm text-gray-500">Optimization</div>
                    </JetBarTableData>
                    <JetBarTableData>
                        <JetBarBadge text="Active" type="success" />
                    </JetBarTableData>
                    <JetBarTableData>Admin</JetBarTableData>
                    <JetBarTableData>
                        <Link href="#" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                    </JetBarTableData>
                    <JetBarTableData>
                        <Link href="#" class="text-gray-400 hover:text-gray-500">
                        <JetBarIcon type="trash" fill />
                        </Link>
                    </JetBarTableData>
                </tr>
            </JetBarTable>

        </JetBarContainer>

    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@res/vue/Layouts/AppLayout.vue'
import JetBarContainer from '@res/vue/Components/JetBar/JetBarContainer.vue';
import JetBarStatsContainer from '@res/vue/Components/JetBar/JetBarStatsContainer.vue';
import JetBarStatCard from '@res/vue/Components/JetBar/JetBarStatCard.vue';
import JetBarTable from '@res/vue/Components/JetBar/JetBarTable.vue';
import JetBarTableData from '@res/vue/Components/JetBar/JetBarTableData.vue';
import JetBarBadge from '@res/vue/Components/JetBar/JetBarBadge.vue';
import JetBarIcon from '@res/vue/Components/JetBar/JetBarIcon.vue';
</script>
