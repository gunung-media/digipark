<template>
    <div
        class="fixed bottom-0 bg-white flex justify-around items-center h-16 w-[450px] max-w-[450px] shadow"
    >
        <div
            v-for="item in navItems"
            :key="item.label"
            class="text-center cursor-pointer"
            :class="isActive(item) ? 'text-[#5561F1]' : 'text-gray-400'"
            @click="goTo(item.name)"
        >
            <component :is="item.icon" class="w-7 mx-auto" />
            <p class="text-xs mt-1">{{ item.label }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import {
    HomeIcon,
    BriefcaseIcon,
    BuildingOfficeIcon,
    UserCircleIcon,
} from "@heroicons/vue/24/solid";
import { router } from "@inertiajs/vue3";
const props = defineProps<{
    active?: string;
}>();

const navItems = [
    { label: "Home", icon: HomeIcon, name: "home" },
    { label: "Pekerjaan", icon: BriefcaseIcon, name: "job" },
    { label: "Layanan", icon: BuildingOfficeIcon, name: "job" },
    { label: "Akun", icon: UserCircleIcon, name: "job" },
];

const isActive = (item: { name: string }) => {
    return props.active ? props.active === item.name : route.name === item.name;
};

const goTo = (name: string) => {
    router.visit(route(`mobile.${name}`));
};
</script>

<style scoped>
/* Optional hover effect */
.text-center:hover {
    color: #5561f1;
}
</style>
