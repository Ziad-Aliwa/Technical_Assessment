<script setup>

defineProps({
    show: Boolean,
    message: String,
    type: {
        type: String,
        default: 'success',
    },
});

</script>

<template>

<transition name="fade">

<div
    v-if="show"
    class="fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"
    :class="{
        'bg-green-600': type === 'success',
        'bg-red-600': type === 'error',
    }"
>

    {{ message }}

</div>

</transition>

</template>

<style scoped>

.fade-enter-active,
.fade-leave-active{

transition:.3s;

}

.fade-enter-from,
.fade-leave-to{

opacity:0;

transform:translateY(-20px);

}

</style>