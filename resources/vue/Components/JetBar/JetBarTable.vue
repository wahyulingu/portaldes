<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <slot name="head" />
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <slot />
                        </tbody>
                    </table>

                    <slot name="pagination" />

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "JetBarTable",
    data() {
        return {
            items: 3,
        }
    }
}
</script>
