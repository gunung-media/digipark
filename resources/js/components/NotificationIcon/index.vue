<template>
    <BellIcon
        class="w-8 cursor-pointer text-gray-700 hover:text-yellow-600 transition duration-200 jiggle-on-hover"
    />
</template>

<script setup lang="ts">
import { BellIcon } from "@heroicons/vue/24/outline";
</script>

<style scoped>
@keyframes jiggle {
    0%,
    100% {
        transform: rotate(0deg);
    }

    25% {
        transform: rotate(-10deg);
    }

    75% {
        transform: rotate(10deg);
    }
}

.jiggle-on-hover:hover {
    animation: jiggle 0.4s ease-in-out;
}
</style>
