<template>
    <div
        @click="onClick"
        class="group cursor-pointer select-none transition duration-150 border-b border-gray-200 hover:bg-gray-50 px-2 py-5"
    >
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <component
                    :is="icon"
                    class="w-6 h-6 text-gray-500 group-hover:text-gray-700 transition"
                />
                <p
                    class="text-sm font-medium text-gray-800 group-hover:text-black"
                >
                    {{ title }}
                </p>
            </div>
            <ArrowRightCircleIcon
                class="w-6 h-6 text-gray-300 group-hover:text-green-600 transition"
            />
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import { ArrowRightCircleIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    icon: {
        type: [Object, Function],
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    onClick: {
        type: Function,
        default: () => {},
    },
});
</script>
