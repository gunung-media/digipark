<template>
    <div class="px-4 mt-4">
        <div class="bg-[#5561F1] text-white rounded-xl p-4 relative">
            <div class="flex justify-between items-start">
                <div class="flex gap-2 items-center">
                    <TruckIcon class="w-7" />
                    <p class="font-semibold text-base">Klaim JHT</p>
                </div>
                <button class="cursor-pointer">&times;</button>
            </div>
            <p class="text-md mt-5 font-thin">Pantau Proses Klaim JHT Kamu</p>
            <button
                class="w-full text-white font-bold mt-10 text-right cursor-pointer"
                @click="openTrackJht"
            >
                Track Proses
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { TruckIcon } from "@heroicons/vue/24/solid";
import { router } from "@inertiajs/vue3";

const openTrackJht = () => {
    router.visit(route("mobile.service.jht"));
};
</script>
