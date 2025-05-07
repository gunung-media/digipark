<template>
    <div class="flex items-center my-2 text-sm text-gray-700">
        <MapPinIcon class="w-4 h-4 text-green-500 mr-1" />
        <span
            >Lokasi Saat ini :
            <span class="text-blue-600 font-medium">{{ location }}</span></span
        >
    </div>
</template>

<script setup>
import { MapPinIcon } from "@heroicons/vue/24/solid";
const props = defineProps({ location: String });
</script>
