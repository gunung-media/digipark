<template>
    <div v-if="news">
        <Head :title="news.title" />
        <Back heading="Berita" />

        <div class="flex justify-center mt-6">
            <img :src="`${storageUrl}/${news.image}`" alt="News Illustration" />
        </div>

        <div class="px-4 mt-2 mb-6 flex font-thin text-xs text-gray-500 gap-5">
            <div class="flex gap-2">
                <CalendarIcon class="w-3" />
                <p>{{ formattedDate(news.created_at) }}</p>
            </div>

            <div class="flex gap-2">
                <UserIcon class="w-3" />
                <p>{{ news.author }}</p>
            </div>
        </div>

        <div class="text-center font-semibold text-gray-800">
            <p>{{ news.title }}</p>
        </div>

        <div class="mt-6 px-4">
            <div v-html="news.body" class="rich-text-content"></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import Back from "@/components/Back/index.vue";
import { UserIcon, CalendarIcon } from "@heroicons/vue/24/solid";
import dayjs from "dayjs";

const page = usePage();
const storageUrl = computed(() => page.props.storageUrl);

defineProps({
    news: Object,
});

const selected = ref("main");

const formattedDate = (created_at: string) =>
    dayjs(created_at).format("DD MMM, YYYY");
</script>

<style scoped>
:deep(.rich-text-content) {
    font-size: 0.875rem !important;
    font-weight: 300 !important;
    line-height: 1.6 !important;
    color: #374151 !important;
}

:deep(.rich-text-content p) {
    margin: 0 0 1em 0 !important;
    text-indent: 0 !important;
}

:deep(.rich-text-content ul),
:deep(.rich-text-content ol) {
    padding-left: 1.5em !important;
    margin-bottom: 1em !important;
}

:deep(.rich-text-content li) {
    margin-bottom: 0.5em !important;
}

:deep(.rich-text-content h1),
:deep(.rich-text-content h2),
:deep(.rich-text-content h3) {
    margin: 1em 0 0.5em 0 !important;
    font-weight: 600 !important;
}

:deep(.rich-text-content br + br) {
    display: none !important;
}

:deep(.rich-text-content table) {
    margin-left: 0 !important;
    width: 100% !important;
    border-collapse: collapse !important;
    margin-bottom: 1em !important;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
    text-align: left !important;
}

:deep(.rich-text-content th),
:deep(.rich-text-content td) {
    border: 1px solid #d1d5db !important;
    padding: 0.5em 0.75em !important;
}

:deep(.rich-text-content thead) {
    background-color: #f9fafb !important;
    font-weight: 600 !important;
}
</style>
