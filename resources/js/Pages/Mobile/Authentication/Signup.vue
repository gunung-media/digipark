<template>
    <Head title="Daftar" />
    <div class="">
        <Back />

        <!-- Page Title -->
        <h1 class="text-2xl font-semibold mt-4 text-gray-800 p-4">
            Daftar Akun
        </h1>

        <div class="flex flex-col justify-between px-4 mt-5 h-[77vh]">
            <form class="space-y-4">
                <Input
                    label="Nama"
                    id="name"
                    placeholder="Masukkan nama anda"
                    v-model="form.name"
                    type="text"
                />

                <Input
                    label="Email"
                    id="email"
                    placeholder="Masukkan alamat email"
                    v-model="form.email"
                    type="email"
                />

                <Input
                    label="Password"
                    id="password"
                    placeholder="******"
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
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import Input from "@/components/Input/index.vue";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";

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
</script>
