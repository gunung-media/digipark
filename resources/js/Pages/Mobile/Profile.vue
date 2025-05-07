<template>
    <Head title="Akun" />
    <div class="p-4">
        <div class="flex items-center justify-between mt-2 mb-10">
            <p class="text-2xl font-bold">Akun</p>
            <BellIcon class="w-8 cursor-pointer text-gray-700" />
        </div>

        <div class="flex items-center gap-5">
            <img
                :src="`https://ui-avatars.com/api/?rounded=true&name=${'Richie Zakaria'}`"
                className="w-px-40 h-auto rounded-circle"
            />
            <div>
                <p class="font-bold">Richie Zakaria</p>
                <p class="text-sm font-thin">Tidak memiliki pekerjaan</p>
            </div>
        </div>

        <div class="mt-18">
            <p class="text-lg font-semibold leading-2">Akun</p>
            <AccountItem
                :icon="UserCircleIcon"
                title="Edit Akun"
                :onClick="() => router.visit('/mobile/home')"
            />
            <AccountItem
                :icon="LockClosedIcon"
                title="Ganti Password"
                :onClick="() => router.visit('/mobile/home')"
            />
        </div>

        <Button
            title="Logout"
            type="primary"
            class="mt-66"
            :onClick="() => router.visit('/mobile')"
        />
    </div>
    <BottomNav active="profile" />
</template>

<script setup lang="ts">
import BottomNav from "@/components/BottomNav/index.vue";
import {
    BellIcon,
    UserCircleIcon,
    LockClosedIcon,
} from "@heroicons/vue/24/outline";
import { router, Head } from "@inertiajs/vue3";

import Button from "@/components/Button/index.vue";
import AccountItem from "@/components/AccountItem/index.vue";
</script>
