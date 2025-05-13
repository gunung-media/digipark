<template>
    <Head title="Akun" />
    <div class="p-4">
        <div class="flex items-center justify-between mt-2 mb-10">
            <p class="text-2xl font-bold">Akun</p>
            <BellIcon class="w-8 cursor-pointer text-gray-700" />
        </div>

        <div class="flex items-center gap-5">
            <img
                :src="`https://ui-avatars.com/api/?rounded=true&name=${user.full_name}`"
                className="w-px-40 h-auto rounded-circle"
            />
            <div>
                <p class="font-bold">{{ user.full_name }}</p>
                <p class="text-sm font-thin">Tidak memiliki pekerjaan</p>
            </div>
        </div>

        <div class="mt-18">
            <p class="text-lg font-semibold leading-2">Akun</p>
            <MenuItem
                :icon="UserCircleIcon"
                title="Edit Akun"
                :onClick="() => redirect('mobile.profile.edit')"
            />
            <MenuItem
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
    <BottomNav active="profile.index" />
</template>

<script setup lang="ts">
import BottomNav from "@/components/BottomNav/index.vue";
import {
    BellIcon,
    UserCircleIcon,
    LockClosedIcon,
} from "@heroicons/vue/24/outline";
import { router, Head, usePage } from "@inertiajs/vue3";

import Button from "@/components/Button/index.vue";
import MenuItem from "@/components/MenuItem/index.vue";
import { computed } from "vue";

const page = usePage();
const user = computed(
    () => (page.props.auth as { user: { full_name: string } }).user,
);

const redirect = (routeName: string) => {
    console.log(routeName);
    router.visit(route(routeName));
};
</script>
