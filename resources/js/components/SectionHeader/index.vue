<template>
    <div class="flex justify-between items-center px-4 mt-6 mb-2">
        <h2 class="text-lg font-semibold">{{ title }}</h2>
        <button class="text-sm text-[#5561F1] font-medium">
            {{ linkText }}
        </button>
    </div>
</template>

<script setup lang="ts">
defineProps({
    title: String,
    linkText: String,
});
</script>
