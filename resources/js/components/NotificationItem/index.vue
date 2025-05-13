<template>
    <div
        class="flex p-4 text-gray-700 transition duration-200 ease-in-out justify-between group cursor-pointer"
        :class="
            !isRead ? 'bg-gray-100 rounded-lg hover:bg-gray-200 shadow' : ''
        "
    >
        <div class="flex gap-4">
            <component :is="icon" class="w-6 h-6 mt-1 shrink-0" />

            <div>
                <p v-if="title" class="text-sm text-gray-500">{{ title }}</p>
                <p class="font-semibold leading-snug">
                    {{ message }}
                </p>
                <p v-if="timestamp" class="text-xs text-gray-400 mt-1">
                    {{ timestamp }}
                </p>
            </div>
        </div>

        <p
            v-if="!isRead"
            class="text-red-500 font-bold group-hover:text-red-800"
        >
            *
        </p>
    </div>
</template>

<script setup lang="ts">
import type { Component } from "vue";

defineProps<{
    icon: Component;
    title?: string;
    message: string;
    timestamp?: string;
    isRead?: boolean;
}>();
</script>

<style scoped>
/* Optional subtle hover or animation styles can go here */
</style>
