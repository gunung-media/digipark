<template>
    <Head title="Home" />
    <div class="bg-white min-h-screen pb-20">
        <SearchBar />
        <div class="p-4">
            <div class="relative rounded-xl overflow-hidden">
                <img
                    src="@/assets/images/slider/1.png"
                    alt="Promo"
                    class="w-full object-contain"
                />
                <div class="absolute inset-0 flex flex-col justify-center px-4">
                    <div class="absolute inset-0 bg-black opacity-20"></div>

                    <div class="relative z-10">
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
            </div>
            <div class="flex justify-center mt-2 space-x-1">
                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
            </div>
        </div>

        <div class="px-4 mt-4">
            <div class="bg-[#5561F1] text-white rounded-xl p-4 relative">
                <div class="flex justify-between items-start">
                    <div class="flex gap-2 items-center">
                        <TruckIcon class="w-7" />
                        <p class="font-semibold text-base">Klaim JHT</p>
                    </div>
                    <button class="cursor-pointer">&times;</button>
                </div>
                <p class="text-md mt-5 font-thin">
                    Pantau Proses Klaim JHT Kamu
                </p>
                <button
                    class="w-full text-white font-bold mt-10 text-right cursor-pointer"
                    @click="openTrackJht"
                >
                    Track Proses
                </button>
            </div>
        </div>

        <SectionHeader
            title="Lowongan terbaru"
            linkText="Lihat Semua"
            routeName="mobile.job.index"
        />
        <JobCard :job="job" :storageUrl="storageUrl" class="m-4" />

        <SectionHeader title="Berita" linkText="Lihat Semua" />
        <div class="flex overflow-x-auto space-x-4 p-4 mt-5">
            <NewsCard
                v-for="(n, i) in news"
                :news="n!"
                :storageUrl="storageUrl!"
                :key="i"
            />
        </div>

        <BottomNav active="home" />
    </div>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import SearchBar from "@/components/SearchBar/index.vue";
import SectionHeader from "@/components/SectionHeader/index.vue";
import JobCard from "@/components/JobCard/index.vue";
import NewsCard from "@/components/NewsCard/index.vue";
import BottomNav from "@/components/BottomNav/index.vue";
import { TruckIcon } from "@heroicons/vue/24/solid";

defineProps({
    job: Object,
    news: Array,
    storageUrl: String,
});

const openTrackJht = () => {
    window.open(route("filament.seeker.resources.claim-jhts.index"));
};
</script>
