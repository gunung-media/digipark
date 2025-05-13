<template>
    <Head title="List Pekerjaan" />
    <div>
        <SearchBar placeholder="Cari lowongan disini">
            <LocationInfo
                label="Lokasi Saat ini"
                location="Palangka Raya, Kalteng"
            />
        </SearchBar>

        <div class="bg-[#F2F2F2] p-4">
            <div
                class="flex items-center justify-between bg-yellow-100 rounded-xl p-4 cursor-pointer hover:bg-yellow-200 group"
                @click="handleOpenConsultation"
            >
                <div class="flex items-start">
                    <ChatBubbleLeftRightIcon
                        class="w-6 h-6 text-yellow-700 mr-2 mt-1 group-hover:text-yellow-800"
                    />
                    <div>
                        <div
                            class="font-semibold text-yellow-800 text-sm group-hover:text-yellow-700"
                        >
                            Ada Pertanyaan?
                        </div>
                        <div class="text-yellow-700 text-xs">
                            Konsultasi kan dengan kami sekarang
                        </div>
                    </div>
                </div>
                <ChevronRightIcon
                    class="w-5 h-5 text-yellow-600 group-hover:text-yellow-800"
                />
            </div>
        </div>

        <CategoryFilter :categories="categories" v-model="selectedCategory" />

        <div class="grid grid-cols-2 px-4">
            <JobCard
                v-for="job in jobs"
                :key="job.id"
                :job="job"
                :storageUrl="storageUrl"
            />
        </div>

        <BottomNav active="job.index" />
    </div>
</template>

<script setup>
import SearchBar from "@/components/SearchBar/index.vue";
import LocationInfo from "@/components/LocationInfo/index.vue";
import JobCard from "@/components/JobCard/index.vue";
import CategoryFilter from "@/components/CategoryFilter/index.vue";
import BottomNav from "@/components/BottomNav/index.vue";
import { ref } from "vue";
import {
    ChatBubbleLeftRightIcon,
    ChevronRightIcon,
} from "@heroicons/vue/24/outline";
import { Head } from "@inertiajs/vue3";

const categories = ["Semua"];
const selectedCategory = ref("Semua");

defineProps({
    jobs: Array,
    storageUrl: String,
});

const handleOpenConsultation = () => window.open(route("portal.consultation"));
</script>
