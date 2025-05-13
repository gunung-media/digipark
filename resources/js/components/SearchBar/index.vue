<template>
    <div class="relative w-full">
        <div
            class="flex items-center bg-gray-50 rounded-xl px-4 py-3 border border-gray-300"
        >
            <MagnifyingGlassIcon class="w-7 text-gray-400 mr-2" />
            <input
                :placeholder="placeholder"
                class="bg-transparent outline-none flex-1 placeholder:text-gray-400 text-gray-800 text-sm"
                type="text"
                v-model="searchQuery"
                @input="fetchResults"
                @blur="clearResults"
            />
        </div>

        <ul
            v-if="results.length > 0"
            class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto px-5"
        >
            <li
                v-for="job in results"
                :key="job.id"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-800 flex gap-3 text-xs"
                @click="selectJob(job)"
            >
                <img
                    :src="`${storageUrl}/${job.image ?? job.company.image}`"
                    alt="image"
                    class="w-10 h-10 object-cover rounded"
                />
                <div>
                    <p class="font-thin">{{ job.name_job }}</p>
                    <p class="font-semibold">{{ job.company.name }}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
import { computed, ref } from "vue";
import axios from "axios";
import { debounce } from "lodash-es";
import { router, usePage } from "@inertiajs/vue3";

const props = defineProps({
    placeholder: {
        type: String,
        default: "Cari Pekerjaan",
    },
});

const page = usePage();

const storageUrl = computed(() => page.props.storageUrl);

const emit = defineEmits(["selected"]);

const searchQuery = ref("");
const results = ref<any[]>([]);

const fetchResults = debounce(async () => {
    if (!searchQuery.value.trim()) {
        results.value = [];
        return;
    }

    const { data } = await axios.get(route("mobile.job.search"), {
        params: { search: searchQuery.value },
    });

    results.value = data.jobs ?? [];
}, 300);

function selectJob(job: any) {
    emit("selected", job);
    router.visit(route("mobile.job.detail", { id: job.id }));
}

function clearResults() {}
</script>
