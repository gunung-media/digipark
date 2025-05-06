<template>
    <div class="px-4">
        <div class="relative rounded-xl overflow-hidden">
            <img
                src="/images/promo.jpg"
                alt="Promo"
                class="w-full h-36 object-cover"
            />
            <div
                class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center px-4"
            >
                <h2 class="text-white text-lg font-semibold">
                    Cek proses pendaftaranmu!
                </h2>
                <p class="text-white text-sm mt-1">
                    Lowongan yang kamu daftar ada disini
                </p>
                <button
                    class="mt-3 bg-white text-black px-3 py-1 rounded-md w-max text-sm font-medium"
                >
                    Lihat Detail
                </button>
            </div>
        </div>
        <div class="flex justify-center mt-2 space-x-1">
            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
            <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
        </div>
    </div>
</template>

<script setup lang="ts"></script>
