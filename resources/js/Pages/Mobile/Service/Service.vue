<template>
    <Head title="Layanan" />
    <div class="p-4">
        <div class="flex items-center justify-between mt-2 mb-10">
            <p class="text-2xl font-bold">Layanan</p>
            <NotificationIcon />
        </div>

        <TrackYourJht />

        <div class="mt-20">
            <MenuItem
                :icon="UserCircleIcon"
                title="Klaim JHT"
                :onClick="() => goTo('mobile.service.claim-jht')"
                :withBorder="true"
            />

            <MenuItem
                :icon="UserCircleIcon"
                title="Lamaran Saya"
                :onClick="() => goTo('mobile.service.job-app')"
                :withBorder="true"
            />

            <MenuItem
                :icon="UserCircleIcon"
                title="Track Klaim Jht"
                :onClick="() => goTo('mobile.service.jht')"
                :withBorder="true"
            />
        </div>
    </div>
    <BottomNav active="service.index" />
</template>

<script setup lang="ts">
import BottomNav from "@/components/BottomNav/index.vue";
import { UserCircleIcon } from "@heroicons/vue/24/outline";
import { router, Head } from "@inertiajs/vue3";
import TrackYourJht from "@/components/TrackYourJht/index.vue";
import NotificationIcon from "@/components/NotificationIcon/index.vue";

import MenuItem from "@/components/MenuItem/index.vue";
import { useToastFlash } from "@/composables/useToastFlash";

const goTo = (name: string) => router.visit(route(name));

useToastFlash();
</script>
