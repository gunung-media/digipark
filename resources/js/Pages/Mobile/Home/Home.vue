<template>
    <Head title="Home" />
    <div class="bg-white min-h-screen pb-20">
        <div class="flex w-full items-center gap-3 px-4 py-2">
            <div class="flex-1">
                <SearchBar class="w-full" />
            </div>
            <NotificationIcon />
        </div>
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
        </div>

        <TrackYourJht />

        <SectionHeader
            title="Lowongan terbaru"
            linkText="Lihat Semua"
            routeName="mobile.job.index"
        />
        <JobCard :job="job" :storageUrl="storageUrl" class="m-4" />

        <SectionHeader
            title="Berita"
            :linkText="`${showAllNews ? 'Tutup' : 'Lihat Semua'}`"
            :onClick="() => (showAllNews = !showAllNews)"
        />
        <div
            class="px-4 mt-5"
            :class="
                showAllNews
                    ? 'grid grid-cols-2'
                    : 'flex overflow-x-auto space-x-4 '
            "
        >
            <NewsCard
                v-for="(n, i) in !showAllNews ? news!.slice(0, 5) : news"
                :news="n!"
                :storageUrl="storageUrl!"
                :key="i"
                :class="showAllNews ? 'min-w-auto m-2' : ''"
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
import TrackYourJht from "@/components/TrackYourJht/index.vue";
import NotificationIcon from "@/components/NotificationIcon/index.vue";
import { ref } from "vue";

defineProps({
    job: Object,
    news: Array,
    storageUrl: String,
});

const showAllNews = ref(false);
</script>
