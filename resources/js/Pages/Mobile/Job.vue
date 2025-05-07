<template>
    <div>
        <SearchBar placeholder="Cari lowongan disini">
            <LocationInfo
                label="Lokasi Saat ini"
                location="Palangka Raya, Kalteng"
            />
        </SearchBar>

        <SectionHeader
            icon="message-circle"
            title="Ada pertanyaan ?"
            subtitle="Konsultasi kan dengan kami sekarang"
            :arrow="true"
        />

        <CategoryFilter :categories="categories" v-model="selectedCategory" />

        <div class="grid grid-cols-2 gap-4 px-4">
            <JobCard
                v-for="job in filteredJobs"
                :key="job.id"
                :image="job.image"
                :title="job.title"
                :company="job.company"
                :location="job.location"
                :note="job.note"
                :highlight="job.highlight"
            />
        </div>

        <BottomNav active="pekerjaan" />
    </div>
</template>

<script setup>
import SearchBar from "@/components/SearchBar/index.vue";
import LocationInfo from "@/components/LocationInfo/index.vue";
import SectionHeader from "@/components/SectionHeader/index.vue";
import JobCard from "@/components/JobCard/index.vue";
import CategoryFilter from "@/components/CategoryFilter/index.vue";
import BottomNav from "@/components/BottomNav/index.vue";
import { ref, computed } from "vue";

const categories = ["Semua", "Admin", "Operator", "Teknisi"];
const selectedCategory = ref("Semua");
const jobs = [
    /* ...job list */
];

const filteredJobs = computed(() => {
    if (selectedCategory.value === "Semua") return jobs;
    return jobs.filter((job) => job.category === selectedCategory.value);
});
</script>
