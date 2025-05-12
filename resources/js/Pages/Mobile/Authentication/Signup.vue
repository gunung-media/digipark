<template>
    <Head title="Daftar" />
    <div class="">
        <Back />

        <h1 class="text-2xl font-semibold mt-4 text-gray-800 p-4">
            Daftar Akun
        </h1>

        <div class="px-4 mt-5 flex-grow">
            <form
                method="POST"
                class="space-y-4 flex flex-col min-h-[75vh]"
                @submit.prevent="submitForm"
            >
                <Input
                    label="Nama"
                    id="full_name"
                    placeholder="Masukkan nama anda"
                    v-model="form.full_name"
                    type="text"
                    :error="form.errors.full_name"
                    isRequired
                />

                <Input
                    label="Email"
                    id="email"
                    placeholder="Masukkan alamat email"
                    v-model="form.email"
                    type="email"
                    :error="form.errors.email"
                    isRequired
                />

                <Input
                    label="Nomor Telepon/WA"
                    id="phone_number"
                    placeholder="Masukkan nomor telepon/whatsapp"
                    v-model="form.phone_number"
                    type="text"
                    :error="form.errors.phone_number"
                    isRequired
                />

                <Input
                    label="Password"
                    id="password"
                    placeholder="******"
                    v-model="form.password"
                    type="password"
                    :error="form.errors.password"
                    isRequired
                />

                <RadioGroup
                    label="Jenis Kelamin"
                    :options="[
                        { label: 'Laki-laki', value: 'male' },
                        { label: 'Perempuan', value: 'female' },
                    ]"
                    name="gender"
                    layout="horizontal"
                    v-model="form.gender"
                    :error="form.errors.gender"
                    :isRequired="true"
                />

                <Input
                    label="Tanggal Lahir"
                    id="date_of_birth"
                    v-model="form.date_of_birth"
                    type="date"
                    :error="form.errors.date_of_birth"
                    isRequired
                />

                <div class="mt-auto pt-4">
                    <Button title="Daftar" type="primary" class="w-full" />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, router, useForm } from "@inertiajs/vue3";
import Input from "@/components/Input/index.vue";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import RadioGroup from "@/components/RadioGroup/index.vue";
import { useToastFlash } from "@/composables/useToastFlash";

const form = useForm({
    full_name: "",
    email: "",
    password: "",
    gender: "",
    date_of_birth: "",
    phone_number: "",
});

const submitForm = () => {
    form.post(route("mobile.signup.store"), {
        onError: (errors) => {
            console.log(errors);
        },
        onSuccess: () => {
            console.log("Success");
        },
    });
};
useToastFlash();
</script>
