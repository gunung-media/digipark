<template>
    <div
        class="flex items-center px-4 pt-6 space-x-2 cursor-pointer"
        @click="goBack"
    >
        <button @click="goBack" class="text-gray-600 hover:text-green-500">
            <!-- Back Icon -->
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
        <span class="text-sm font-medium text-gray-600">Kembali</span>
    </div>
</template>

<script setup lang="ts">
import { router } from "@inertiajs/vue3";
const goBack = () => {
    window.history.length > 1 ? window.history.back() : router.visit("/");
};
</script>
