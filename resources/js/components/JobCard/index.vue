<template>
    <div
        class="rounded-xl bg-white shadow-sm overflow-hidden m-4 max-w-[250px] cursor-pointer"
    >
        <img
            :src="`${storageUrl}/${job.image}`"
            class="w-full h-24 object-cover"
        />
        <div class="p-3">
            <div class="text-xs text-gray-500">{{ job.name_job }}</div>
            <div class="font-semibold text-sm truncate">
                {{ job.company.name }}
            </div>
            <div class="text-xs text-gray-500 mt-1 flex items-center">
                <MapPinIcon class="w-7 mr-1" />
                <p class="truncate">{{ job.address }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { MapPinIcon } from "@heroicons/vue/24/outline";
const props = defineProps({
    storageUrl: String,
    job: Object,
    highlightNote: String,
    highlightColor: String,
});
</script>
