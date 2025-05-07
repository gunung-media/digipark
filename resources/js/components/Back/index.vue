<template>
    <div class="relative px-4 pt-6 w-full">
        <div
            class="absolute left-4 top-6 flex items-center space-x-2 cursor-pointer"
            @click="goBack"
        >
            <button class="text-gray-600 hover:text-green-500">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </button>
            <span
                v-if="!props.heading"
                class="text-sm font-medium text-gray-600"
                >Kembali</span
            >
        </div>

        <h1
            v-if="props.heading"
            class="text-center text-xl font-semibold text-gray-800"
        >
            {{ props.heading }}
        </h1>
    </div>
</template>

<script setup lang="ts">
import { router } from "@inertiajs/vue3";
const goBack = () => {
    window.history.length > 1 ? window.history.back() : router.visit("/");
};
const props = defineProps({
    heading: String,
});
</script>
