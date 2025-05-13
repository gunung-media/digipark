<template>
    <Head title="Edit Profile" />
    <div>
        <Back heading="Edit Profile" />

        <div class="flex items-center justify-center mt-8">
            <img
                :src="`https://ui-avatars.com/api/?rounded=true&name=${form.full_name ?? 'NO Account'}`"
                className="w-px-40 h-auto rounded-circle"
            />
        </div>

        <form class="mt-6 px-4" @submit.prevent="handleSubmit">
            <div class="space-y-4 flex flex-col min-h-[75vh]">
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
                    label="Alamat"
                    id="address"
                    placeholder="Masukkan alamat"
                    v-model="form.address"
                    type="text"
                    :error="form.errors.address"
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
                <Button title="Simpan" type="primary" class="mt-8" />
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import RadioGroup from "@/components/RadioGroup/index.vue";
import Input from "@/components/Input/index.vue";
import { toast } from "vue3-toastify";
const props = defineProps<{ user: any }>();
const form = useForm({
    full_name: props.user.full_name,
    address: props.user.address,
    email: props.user.email,
    gender: props.user.gender,
    date_of_birth: props.user.date_of_birth,
    phone_number: props.user.phone_number,
});

const handleSubmit = () => {
    form.post(route("mobile.profile.edit.proceed"), {
        onError: (errors) => {
            console.error(errors);
        },
        onSuccess: () => {
            toast.success("Profile berhasil disimpan");
        },
    });
};
</script>
