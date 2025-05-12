<template>
    <Head title="Hi" />
    <transition name="fade" mode="out-in">
        <img
            :key="onboardingItem[currentItem].image"
            :src="onboardingItem[currentItem].image"
            alt="Illustration"
            class="w-full"
        />
    </transition>
    <div class="flex flex-col justify-between px-4">
        <div class="text-center mt-8">
            <h1 class="text-xl font-semibold text-gray-800 mb-2">
                {{ onboardingItem[currentItem].title }}
            </h1>
            <p class="text-sm text-gray-500">
                {{ onboardingItem[currentItem].text }}
            </p>
        </div>

        <div class="flex justify-center space-x-1 mt-6">
            <span
                v-for="(i, key) in onboardingItem.length"
                class="w-2 h-2 rounded-full cursor-pointer"
                :class="key == currentItem ? 'bg-green-500' : 'bg-gray-300'"
                :key="key"
                @click="onDotClick(key)"
            ></span>
        </div>

        <div class="w-full mt-10 space-y-3">
            <Button title="Daftar" type="primary" @click="goSignUp" />
            <Button
                title="Sudah Punya Akun"
                type="secondary"
                @click="goLogin"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Button from "@/components/Button/index.vue";
import Onboarding from "@/assets/images/onboarding.png";
import OnboardingTwo from "@/assets/images/onboarding2.png";
import OnboardingThird from "@/assets/images/onboarding3.png";
import { onMounted, onUnmounted, ref } from "vue";
import { Head, router } from "@inertiajs/vue3";

const onboardingItem = [
    {
        title: "Temukan Pekerjaan Impianmu",
        image: Onboarding,
        text: "Jelajahi lowongan kerja dari berbagai tempat. Temukan yang cocok, langsung lamar sekarang juga!",
    },

    {
        title: "Cari Kerja Lebih Seru",
        image: OnboardingTwo,
        text: "Scroll, pilih, lamar—semudah itu cari kerja sekarang. Yuk, mulai langkah pertama ke karier impianmu!",
    },

    {
        title: "Nggak Perlu Bingung Lagi Cari Lowongan",
        image: OnboardingThird,
        text: "Semua info kerja ada di satu aplikasi. Tinggal cari yang cocok dan langsung gas daftar!",
    },
];

const currentItem = ref(0);

const onDotClick = (key: number) => (currentItem.value = key);

let intervalId: ReturnType<typeof setInterval>;

onMounted(() => {
    intervalId = setInterval(() => {
        currentItem.value = (currentItem.value + 1) % onboardingItem.length;
    }, 5000);
});

onUnmounted(() => {
    clearInterval(intervalId);
});

const goLogin = () => router.visit(route("mobile.login"));
const goSignUp = () => router.visit(route("mobile.signup"));
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
