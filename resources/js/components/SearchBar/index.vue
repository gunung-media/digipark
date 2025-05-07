<template>
    <div class="px-4 pt-4">
        <div
            class="flex items-center bg-gray-50 rounded-xl px-4 py-3 border border-gray-300"
        >
            <MagnifyingGlassIcon class="w-7 text-gray-400 mr-2" />
            <input
                :placeholder="placeholder"
                class="bg-transparent outline-none flex-1 placeholder:text-gray-400 text-gray-800 text-sm"
                type="text"
            />
        </div>
        <slot />
    </div>
</template>

<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
const props = defineProps({
    placeholder: {
        type: String,
        default: "Cari Pekerjaan",
    },
});
</script>
