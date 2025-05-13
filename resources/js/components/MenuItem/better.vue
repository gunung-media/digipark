<template>
    <div
        @click="onClick"
        class="flex items-center justify-between p-5 mb-4 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-200 cursor-pointer group"
    >
        <div class="flex items-center gap-4">
            <div class="bg-gray-100 p-3 rounded-full">
                <component
                    :is="icon"
                    class="w-6 h-6 text-gray-500 group-hover:text-green-600 transition"
                />
            </div>
            <p
                class="text-gray-800 font-medium group-hover:text-green-800 transition"
            >
                {{ title }}
            </p>
        </div>
        <ArrowRightCircleIcon
            class="w-6 h-6 text-gray-400 group-hover:text-green-600 transition"
        />
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
