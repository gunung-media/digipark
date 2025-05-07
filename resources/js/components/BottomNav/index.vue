<template>
    <div
        class="fixed bottom-0 bg-white flex justify-around items-center h-16 w-[450px] max-w-[450px] shadow"
    >
        <div
            v-for="item in navItems"
            :key="item.label"
            class="text-center"
            :class="isActive(item) ? 'text-[#5561F1]' : 'text-gray-400'"
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
const props = defineProps<{
    active?: string;
}>();

const navItems = [
    { label: "Home", icon: HomeIcon, name: "home" },
    { label: "Pekerjaan", icon: BriefcaseIcon, name: "pekerjaan" },
    { label: "Layanan", icon: BuildingOfficeIcon, name: "layanan" },
    { label: "Akun", icon: UserCircleIcon, name: "akun" },
];

const isActive = (item: { name: string }) => {
    return props.active ? props.active === item.name : route.name === item.name;
};
</script>

<style scoped>
/* Optional hover effect */
.text-center:hover {
    color: #5561f1;
}
</style>
