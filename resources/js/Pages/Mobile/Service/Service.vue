<template>
    <Head title="Layanan" />
    <div class="p-4">
        <div class="flex items-center justify-between mt-2 mb-10">
            <p class="text-2xl font-bold">Layanan</p>
            <BellIcon class="w-8 cursor-pointer text-gray-700" />
        </div>

        <TrackYourJht />

        <div class="mt-20">
            <MenuItem
                :icon="UserCircleIcon"
                title="Klaim JHT"
                :onClick="() => goTo('mobile.service.claim-jht')"
                :withBorder="true"
            />
        </div>
    </div>
    <BottomNav active="service.index" />
</template>

<script setup lang="ts">
import BottomNav from "@/components/BottomNav/index.vue";
import { BellIcon, UserCircleIcon } from "@heroicons/vue/24/outline";
import { router, Head } from "@inertiajs/vue3";
import TrackYourJht from "@/components/TrackYourJht/index.vue";

import MenuItem from "@/components/MenuItem/index.vue";

const goTo = (name: string) => router.visit(route(name));
</script>
