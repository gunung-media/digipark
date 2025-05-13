<template>
    <div class="relative inline-block">
        <BellIcon
            class="w-8 cursor-pointer text-gray-700 hover:text-yellow-600 transition duration-200 jiggle-on-hover"
            @click="handleClick"
        />
        <span
            v-if="totalNotif > 0"
            class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-full border border-white shadow"
        >
            {{ totalNotif }}
        </span>
    </div>
</template>

<script setup lang="ts">
import { BellIcon } from "@heroicons/vue/24/outline";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

const handleClick = () => router.visit(route("mobile.notification"));
const totalNotif = ref(0);

onMounted(() => {
    axios.get(route("mobile.notification.count")).then(({ data }) => {
        totalNotif.value = data?.total ?? 0;
    });
});
</script>

<style scoped>
@keyframes jiggle {
    0%,
    100% {
        transform: rotate(0deg);
    }

    25% {
        transform: rotate(-10deg);
    }

    75% {
        transform: rotate(10deg);
    }
}

.jiggle-on-hover:hover {
    animation: jiggle 0.4s ease-in-out;
}
</style>
