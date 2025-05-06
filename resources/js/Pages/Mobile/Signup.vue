<template>
    <Head title="Daftar" />
    <div class="">
        <div
            class="flex items-center px-4 pt-6 space-x-2 cursor-pointer"
            @click="goBack"
        >
            <button @click="goBack" class="text-gray-600 hover:text-green-500">
                <!-- Back Icon -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </button>
            <span class="text-sm font-medium text-gray-600">Kembali</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-2xl font-semibold mt-4 text-gray-800 p-4">
            Daftar Akun
        </h1>

        <div class="flex flex-col justify-between px-4 mt-5 h-[77vh]">
            <form class="space-y-4">
                <Input label="Nama" id="name" v-model="form.name" type="text" />

                <Input
                    label="Email"
                    id="email"
                    v-model="form.email"
                    type="email"
                />

                <Input
                    label="Password"
                    id="password"
                    v-model="form.password"
                    type="password"
                />

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Jenis Kelamin</label
                    >
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input
                                type="radio"
                                value="Laki-laki"
                                v-model="form.gender"
                                class="text-green-500 focus:ring-green-500"
                            />
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="flex items-center">
                            <input
                                type="radio"
                                value="Perempuan"
                                v-model="form.gender"
                                class="text-green-500 focus:ring-green-500"
                            />
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                </div>

                <Input
                    label="Tanggal Lahir"
                    id="birthdate"
                    v-model="form.birthdate"
                    type="date"
                />
            </form>
            <div>
                <Button title="Daftar" type="primary" @click="submitForm" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
import Input from "@/components/Input/index.vue";
import Button from "@/components/Button/index.vue";

const form = ref({
    name: "",
    email: "",
    password: "",
    passwordConfirmation: "",
    gender: "",
    birthdate: "",
});

const submitForm = () => {
    console.log("Form Submitted:", form.value);
    // You can use Inertia.post() or axios.post() here if submitting to backend
};

const goBack = () => {
    window.history.length > 1 ? window.history.back() : router.visit("/");
};
</script>
