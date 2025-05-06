<template>
    <div class="px-4 mt-4">
        <div class="bg-[#5561F1] text-white rounded-xl px-4 py-4 relative">
            <div class="flex items-center gap-3">
                <div class="bg-white bg-opacity-20 p-2 rounded-full">
                    <svg
                        class="w-6 h-6 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h11M9 21V3m0 0l3.293 3.293a1 1 0 001.414 0L17 3"
                        />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-base">Klaim JHT</p>
                    <p class="text-sm">Pantau Proses Klaim JHT Kamu</p>
                </div>
            </div>
            <button class="absolute right-4 bottom-4 text-white font-bold">
                Track Proses
            </button>
            <button class="absolute top-2 right-2 text-white">&times;</button>
        </div>
    </div>
</template>

<script setup lang="ts"></script>
