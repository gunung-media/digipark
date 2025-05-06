<template>
    <div class="px-4 py-2">
        <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
            <MagnifyingGlassIcon class="w-5 h-5 text-gray-400 mr-2" />
            <input
                :placeholder="placeholder"
                class="bg-transparent outline-none flex-1"
                type="text"
            />
        </div>
        <slot />
    </div>
</template>

<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
const props = defineProps({ placeholder: String });
</script>
