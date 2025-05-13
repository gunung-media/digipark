<template>
    <Head title="Notification" />
    <div>
        <Back heading="Notification" />

        <CategoryFilter
            :categories="categories"
            v-model="selectedCategory"
            class="mt-2"
        />

        <div v-if="groupedNotifications.today.length" class="px-4 mt-4">
            <p class="text-2xl font-bold">Hari Ini</p>
            <div class="flex flex-col gap-1 mt-4">
                <NotificationItem
                    v-for="notif in groupedNotifications.today"
                    :key="notif.id"
                    :title="notif.title"
                    :message="notif.body"
                    :timestamp="notif.created_at"
                    :isRead="notif.read_at !== null"
                    :icon="ExclamationCircleIcon"
                />
            </div>
        </div>

        <div v-if="groupedNotifications.yesterday.length" class="px-4 mt-4">
            <p class="text-2xl font-bold">Kemarin</p>

            <div class="flex flex-col gap-1 mt-4">
                <NotificationItem
                    v-for="notif in groupedNotifications.yesterday"
                    :key="notif.id"
                    :title="notif.title"
                    :message="notif.body"
                    :timestamp="notif.created_at"
                    :isRead="notif.read_at !== null"
                    :icon="ExclamationCircleIcon"
                />
            </div>
        </div>

        <div v-if="groupedNotifications.earlier.length" class="px-4 mt-4">
            <p class="text-2xl font-bold">Sebelumnya...</p>
            <div class="flex flex-col gap-1 mt-4">
                <NotificationItem
                    v-for="notif in groupedNotifications.earlier"
                    :key="notif.id"
                    :title="notif.title"
                    :message="notif.body"
                    :timestamp="notif.created_at"
                    :isRead="notif.read_at !== null"
                    :icon="ExclamationCircleIcon"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// @ts-nocheck
import { Head, usePage } from "@inertiajs/vue3";
import { ExclamationCircleIcon } from "@heroicons/vue/24/outline";
import { computed, ref } from "vue";
import dayjs from "dayjs";
import isToday from "dayjs/plugin/isToday";
import isYesterday from "dayjs/plugin/isYesterday";

import CategoryFilter from "@/components/CategoryFilter/index.vue";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import NotificationItem from "@/components/NotificationItem/index.vue";

const categories = ["Semua"];
const selectedCategory = ref("Semua");

const props = defineProps<{
    notifications: any;
}>();

dayjs.extend(isToday);
dayjs.extend(isYesterday);

const groupedNotifications = computed(() => {
    const today: typeof props.notifications = [];
    const yesterday: typeof props.notifications = [];
    const earlier: typeof props.notifications = [];

    props.notifications.forEach((item: any) => {
        const date = dayjs(item.created_at);

        if (date.isToday()) {
            today.push(item);
        } else if (date.isYesterday()) {
            yesterday.push(item);
        } else {
            earlier.push(item);
        }
    });

    return {
        today,
        yesterday,
        earlier,
    };
});
</script>
