<template>
    <div class="flex justify-between items-center px-4 mt-6 mb-2">
        <h2 class="text-lg font-semibold">{{ title }}</h2>
        <button
            v-if="routeName"
            class="text-sm text-[#5561F1] hover:text-[#5581F2] font-medium cursor-pointer"
            @click="handleClick"
        >
            {{ linkText }}
        </button>
    </div>
</template>

<script setup lang="ts">
import { router } from "@inertiajs/vue3";
const props = defineProps<{
    title: string;
    linkText: string;
    routeName?: string;
}>();

const handleClick = () => router.visit(route(props.routeName ?? ""));
</script>
