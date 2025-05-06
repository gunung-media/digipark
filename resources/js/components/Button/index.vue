<template>
    <button
        @click="onClick"
        :class="buttonClass"
        class="w-full py-3 rounded-md text-sm font-semibold cursor-pointer transition duration-200"
    >
        {{ title }}
    </button>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
    title: string;
    onClick?: () => void;
    type?:
        | "primary"
        | "secondary"
        | "warning"
        | "success"
        | "danger"
        | "info"
        | "light"
        | "dark";
}>();

const buttonClass = computed(() => {
    switch (props.type) {
        case "primary":
            return "bg-green-500 text-white hover:bg-green-600";
        case "secondary":
            return "border border-gray-300 text-gray-700 hover:bg-gray-100";
        case "warning":
            return "bg-yellow-500 text-white hover:bg-yellow-600";
        case "success":
            return "bg-emerald-500 text-white hover:bg-emerald-600";
        case "danger":
            return "bg-red-500 text-white hover:bg-red-600";
        case "info":
            return "bg-sky-500 text-white hover:bg-sky-600";
        case "light":
            return "bg-gray-100 text-gray-800 hover:bg-gray-200";
        case "dark":
            return "bg-gray-800 text-white hover:bg-gray-900";
        default:
            return "bg-gray-200 text-black hover:bg-gray-300";
    }
});
</script>
