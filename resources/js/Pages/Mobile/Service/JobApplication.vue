<template>
    <Head title="Lamaran Saya" />

    <Back heading="Lamaran Saya" />

    <div class="p-4 pb-24">
        <div class="flex space-x-2 mb-4">
            <button
                v-for="tab in tabs"
                :key="tab.value"
                @click="activeTab = tab.value"
                :class="[
                    'px-4 py-2 rounded-full text-sm font-medium border transition',
                    activeTab === tab.value
                        ? 'bg-blue-100 text-blue-600 border-blue-300'
                        : 'bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200',
                ]"
            >
                {{ tab.label }}
            </button>
        </div>

        <div v-if="filteredApplications.length > 0" class="space-y-4">
            <div
                v-for="application in filteredApplications"
                :key="application.id"
                class="bg-white shadow rounded-xl p-4 border border-gray-200 cursor-pointer transition hover:bg-gray-50"
                @click="() => goTo(application.job_id)"
            >
                <div class="flex items-center gap-3">
                    <img
                        :src="`${storageUrl}/${application.job.image ?? application.job.company.image}`"
                        class="w-12 h-12 object-cover rounded-md"
                        alt="logo"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            {{ application.job.name_job }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ application.job.company.name }}
                        </p>
                    </div>
                    <span
                        class="ml-auto px-3 py-1 text-xs rounded-full font-medium"
                        :class="{
                            'bg-yellow-100 text-yellow-600':
                                application.is_accepted === 0,
                            'bg-green-100 text-green-600':
                                application.is_accepted === 1,
                        }"
                    >
                        {{ statusLabel(application.is_accepted) }}
                    </span>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-sm text-gray-500 mt-10">
            Tidak ada lamaran dengan status "{{ statusLabel(activeTab) }}".
        </div>
    </div>

    <BottomNav active="service.index" />
</template>

<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import BottomNav from "@/components/BottomNav/index.vue";
import Back from "@/components/Back/index.vue";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps<{ applications: any[] }>();

const tabs = [
    { label: "Semua", value: -1 },
    { label: "Menunggu", value: 0 },
    { label: "Diterima", value: 1 },
];

const activeTab = ref(-1);
const page = usePage();
const storageUrl = computed(() => page.props.storageUrl);

const filteredApplications = computed(() => {
    return props.applications.filter((app) =>
        activeTab.value === -1 ? true : app.is_accepted === activeTab.value,
    );
});

function statusLabel(status: number): string {
    if (status === 0) return "Menunggu";
    if (status === 1) return "Diterima";
    return "Tidak Diketahui";
}

const goTo = (id: any) => router.visit(route("mobile.job.detail", id));
</script>

<style scoped>
button:focus {
    outline: none;
    ring: none;
}
</style>
