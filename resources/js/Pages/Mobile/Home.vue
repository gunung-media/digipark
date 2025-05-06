<template>
    <Head title="Home" />
    <div class="bg-white min-h-screen pb-20">
        <SearchBar />
        <PromoCarousel />
        <ClaimBanner />
        <SectionHeader title="Lowongan terbaru" linkText="Lihat Semua" />
        <JobCard />
        <SectionHeader title="Berita" linkText="Lihat Semua" />
        <NewsSection />
        <BottomNav />
    </div>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import SearchBar from "@/components/SearchBar/index.vue";
import PromoCarousel from "@/components/PromoCarousel/index.vue";
import ClaimBanner from "@/components/ClaimBanner/index.vue";
import SectionHeader from "@/components/SectionHeader/index.vue";
import JobCard from "@/components/JobCard/index.vue";
import NewsSection from "@/components/NewsSection/index.vue";
import BottomNav from "@/components/BottomNav/index.vue";
</script>
