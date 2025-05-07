<template>
    <div
        @click="onClick"
        class="py-6 flex justify-between text-gray-600 cursor-pointer hover:text-gray-800 group transition duration-200"
        :class="withBorder ? 'border-b border-b-gray-400' : ''"
    >
        <div class="flex items-center gap-5">
            <component :is="icon" class="w-5 group-hover:font-black" />
            <p>{{ title }}</p>
        </div>
        <ArrowRightCircleIcon
            v-if="withBorder"
            class="w-7 group-hover:font-black group-hover:text-green-800"
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
    withBorder: { type: Boolean, default: true },
});
</script>
