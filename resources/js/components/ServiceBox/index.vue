<template>
    <div
        class="flex items-center justify-between bg-yellow-100 rounded-xl mx-4 p-4 mt-4"
    >
        <div class="flex items-start">
            <ChatBubbleLeftRightIcon
                class="w-6 h-6 text-yellow-700 mr-2 mt-1"
            />
            <div>
                <div class="font-semibold text-yellow-800 text-sm">
                    {{ title }}
                </div>
                <div class="text-yellow-700 text-xs">{{ subtitle }}</div>
            </div>
        </div>
        <ChevronRightIcon class="w-5 h-5 text-yellow-600" />
    </div>
</template>

<script setup>
import {
    ChatBubbleLeftRightIcon,
    ChevronRightIcon,
} from "@heroicons/vue/24/outline";
const props = defineProps({ title: String, subtitle: String });
</script>
