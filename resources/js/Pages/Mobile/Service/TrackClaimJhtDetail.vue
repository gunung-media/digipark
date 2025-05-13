<template>
    <Head title="Detail Klaim JHT" />

    <Back heading="Detail Klaim JHT" />

    <div class="p-4 pb-24">
        <div class="bg-white shadow rounded-xl p-4 border border-gray-200 mb-6">
            <p class="text-sm text-gray-500 mb-1">Jenis Klaim</p>
            <p class="text-lg font-semibold text-gray-800 mb-2">
                {{ titleCase(claim.type) }}
            </p>
            <p class="text-sm text-gray-500">
                Diajukan pada: {{ formatDate(claim.created_at) }}
            </p>
            <span
                :class="statusClass(claim.status)"
                class="inline-block mt-2 text-xs font-medium px-3 py-1 rounded-full"
            >
                {{ statusLabel(claim.status) }}
            </span>
        </div>

        <div>
            <h3 class="text-base font-semibold text-gray-800 mb-3">
                Riwayat Proses
            </h3>

            <div
                v-if="tracks.length"
                class="relative border-l border-gray-300 pl-4 space-y-6"
            >
                <div
                    v-for="(track, i) in tracks"
                    :key="track.id"
                    class="relative"
                >
                    <span
                        class="absolute -left-[9px] top-[4px] w-3 h-3 rounded-full bg-blue-500"
                    ></span>

                    <div class="ml-5">
                        <p class="text-sm font-semibold text-gray-800">
                            {{ track.message ?? "Update Status" }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ formatDate(track.created_at) }}
                        </p>
                        <p
                            v-if="track.description"
                            class="text-sm text-gray-600 mt-1"
                        >
                            {{ track.description }}
                        </p>
                    </div>
                </div>
            </div>

            <div v-else class="text-sm text-gray-500 text-center mt-8">
                Belum ada riwayat proses.
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Back from "@/components/Back/index.vue";
import dayjs from "dayjs";

const props = defineProps<{
    claim: any;
    tracks: any[];
}>();

function formatDate(date: string) {
    return dayjs(date).format("DD MMM YYYY, HH:mm");
}

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

const titleCase = (s: string) =>
    s.replace(/^_*(.)|_+(.)/g, (s, c, d) =>
        c ? c.toUpperCase() : " " + d.toUpperCase(),
    );
</script>
