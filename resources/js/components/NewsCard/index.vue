<template>
    <div
        class="min-w-[250px] bg-white shadow rounded-xl overflow-hidden cursor-pointer"
    >
        <img
            :src="`${storageUrl}/${news.image}`"
            alt="News Image"
            class="w-full h-28 object-cover"
        />
        <div class="p-3">
            <p class="text-xs text-gray-400">{{ news.category.name }}</p>
            <p class="text-sm font-semibold truncate" :title="news.title">
                {{ news.title }}
            </p>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    news: Object;
    storageUrl: String;
}>();
</script>
