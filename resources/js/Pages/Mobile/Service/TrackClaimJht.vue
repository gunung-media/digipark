<template>
    <Head title="Klaim JHT Saya" />

    <Back heading="Klaim JHT Saya" />

    <div class="p-4 pb-24">
        <div class="flex space-x-2 mb-4 overflow-x-auto">
            <button
                v-for="tab in tabs"
                :key="tab.value"
                @click="activeTab = tab.value"
                :class="[
                    'px-4 py-2 rounded-full text-sm font-medium border transition whitespace-nowrap',
                    activeTab === tab.value
                        ? 'bg-blue-100 text-blue-600 border-blue-300'
                        : 'bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200',
                ]"
            >
                {{ tab.label }}
            </button>
        </div>

        <div v-if="filteredClaims.length > 0" class="space-y-4">
            <div
                v-for="claim in filteredClaims"
                :key="claim.id"
                @click="goToDetail(claim.id)"
                class="bg-white shadow rounded-xl p-4 border border-gray-200 cursor-pointer transition hover:bg-gray-50"
            >
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            {{ titleCase(claim.type) }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Diajukan pada {{ formatDate(claim.created_at) }}
                        </p>
                    </div>
                    <span
                        class="text-xs px-3 py-1 rounded-full font-semibold"
                        :class="statusClass(claim.status)"
                    >
                        {{ statusLabel(claim.status) }}
                    </span>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-sm text-gray-500 mt-10">
            Tidak ada klaim dengan status "{{ statusLabel(activeTab) }}".
        </div>
    </div>

    <BottomNav active="service.index" />
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { usePage, Head, router } from "@inertiajs/vue3";
import BottomNav from "@/components/BottomNav/index.vue";
import Back from "@/components/Back/index.vue";
import dayjs from "dayjs";

const props = defineProps<{ claims: any[] }>();

const tabs = [
    { label: "Semua", value: "semua" },
    { label: "Diterima", value: "diterima" },
    { label: "Diproses", value: "diproses" },
    { label: "Ditunda", value: "ditunda" },
    { label: "Ditolak", value: "ditolak" },
    { label: "Selesai", value: "selesai" },
];

const activeTab = ref("semua");

const filteredClaims = computed(() =>
    props.claims.filter(
        (c) => activeTab.value === "semua" || c.status === activeTab.value,
    ),
);

function statusLabel(status: string): string {
    const map: Record<string, string> = {
        diproses: "Diproses",
        ditunda: "Ditunda",
        ditolak: "Ditolak",
        diterima: "Diterima",
        selesai: "Selesai",
    };
    return map[status] ?? status;
}

function statusClass(status: string): string {
    const map: Record<string, string> = {
        diproses: "bg-yellow-100 text-yellow-600",
        ditunda: "bg-gray-100 text-gray-600",
        ditolak: "bg-red-100 text-red-600",
        diterima: "bg-blue-100 text-blue-600",
        selesai: "bg-green-100 text-green-600",
    };
    return map[status] ?? "bg-gray-100 text-gray-600";
}

function formatDate(date: string) {
    return dayjs(date).format("DD MMM YYYY, HH:mm");
}

function goToDetail(id: number) {
    router.visit(route("mobile.service.jht.detail", { id }));
}

const titleCase = (s: string) =>
    s.replace(/^_*(.)|_+(.)/g, (s, c, d) =>
        c ? c.toUpperCase() : " " + d.toUpperCase(),
    );
</script>
