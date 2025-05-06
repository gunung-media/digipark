<template>
    <div class="rounded-xl bg-white shadow-sm overflow-hidden">
        <img :src="image" class="w-full h-24 object-cover" />
        <div class="p-3">
            <div class="text-xs text-gray-500">{{ position }}</div>
            <div class="font-semibold text-sm truncate">{{ company }}</div>
            <div v-if="note" class="text-xs text-gray-400 mt-1">{{ note }}</div>
            <div
                v-if="highlightNote"
                :class="[
                    'text-xs rounded-full mt-1 px-2 py-0.5 inline-block',
                    highlightColorClass,
                ]"
            >
                {{ highlightNote }}
            </div>
            <div class="text-xs text-gray-500 mt-1 flex items-center">
                <MapPinIcon class="w-4 h-4 mr-1" />{{ location }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { MapPinIcon } from "@heroicons/vue/24/outline";
import { computed } from "vue";
const props = defineProps({
    image: String,
    position: String,
    company: String,
    note: String,
    highlightNote: String,
    highlightColor: String,
    location: String,
});
const highlightColorClass = computed(() => {
    return props.highlightColor === "red"
        ? "bg-red-100 text-red-500"
        : "bg-green-100 text-green-600";
});
</script>
