<script setup>

defineProps({
    show: Boolean,
    title: String,
    message: String,
});

const emit = defineEmits([
    'confirm',
    'cancel'
]);

</script>

<template>

<div
    v-if="show"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
>

    <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">

        <h2 class="text-xl font-bold mb-4">
            {{ title }}
        </h2>

        <p class="text-gray-700 mb-6">
            {{ message }}
        </p>

        <div class="flex justify-end gap-3">

            <button
                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400"
                @click="$emit('cancel')"
            >
                Cancel
            </button>

            <button
                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                @click="$emit('confirm')"
            >
                Confirm
            </button>

        </div>

    </div>

</div>

</template>