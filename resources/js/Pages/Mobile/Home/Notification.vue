<template>
    <Head title="Notification" />
    <div>
        <Back heading="Notification" />

        <CategoryFilter
            :categories="categories"
            v-model="selectedCategory"
            class="mt-2"
        />

        <div class="px-4 mt-4">
            <p class="text-2xl font-bold">Hari ini</p>

            <div class="flex flex-col gap-1 mt-4">
                <NotificationItem
                    :icon="ExclamationCircleIcon"
                    title="Selamat"
                    message="Laporan Claim JHT diproses oleh Admin"
                    timestamp="13 May 2025, 15:34"
                />
                <NotificationItem
                    :icon="ExclamationCircleIcon"
                    title="Selamat"
                    message="Laporan Claim JHT diproses oleh Admin"
                    timestamp="13 May 2025, 15:34"
                    isRead
                />
            </div>
        </div>

        <div class="px-4 mt-4">
            <p class="text-2xl font-bold">Kemarin</p>

            <div class="flex flex-col gap-1 mt-4">
                <NotificationItem
                    :icon="ExclamationCircleIcon"
                    title="Selamat"
                    message="Laporan Claim JHT diproses oleh Admin"
                    timestamp="13 May 2025, 15:34"
                    isRead
                />
                <NotificationItem
                    :icon="ExclamationCircleIcon"
                    title="Selamat"
                    message="Laporan Claim JHT diproses oleh Admin"
                    timestamp="13 May 2025, 15:34"
                    isRead
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ExclamationCircleIcon } from "@heroicons/vue/24/outline";
import { toast } from "vue3-toastify";
import { computed, ref } from "vue";

import CategoryFilter from "@/components/CategoryFilter/index.vue";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import NotificationItem from "@/components/NotificationItem/index.vue";

const categories = ["Semua"];
const selectedCategory = ref("Semua");

const page = usePage();
const user = computed(
    () => (page.props.auth as { user: { full_name: string } }).user,
);
</script>
