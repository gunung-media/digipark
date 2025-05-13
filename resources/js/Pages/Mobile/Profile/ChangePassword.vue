<template>
    <Head title="Ganti Password" />
    <div>
        <Back heading="Ganti Password" />

        <div class="flex items-center justify-center mt-8">
            <img
                :src="`https://ui-avatars.com/api/?rounded=true&name=${user.full_name ?? 'No Name'}`"
                className="w-px-40 h-auto rounded-circle"
            />
        </div>

        <form class="mt-6 px-4" @submit.prevent="handleSubmit">
            <div class="space-y-4 flex flex-col min-h-[75vh]">
                <Input
                    label="Password Lama"
                    id="old_password"
                    placeholder="Masukkan Password Lama"
                    v-model="form.old_password"
                    type="password"
                    :error="form.errors.old_password"
                    isRequired
                />

                <Input
                    label="Password Baru"
                    id="password"
                    placeholder="Masukkan Password Baru"
                    v-model="form.password"
                    type="text"
                    :error="form.errors.password"
                    isRequired
                />

                <Button title="Simpan" type="primary" class="mt-8" />
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm, usePage } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import Input from "@/components/Input/index.vue";
import { toast } from "vue3-toastify";
import { computed } from "vue";
const form = useForm({
    password: "",
    old_password: "",
});

const page = usePage();
const user = computed(
    () => (page.props.auth as { user: { full_name: string } }).user,
);

const handleSubmit = () => {
    form.post(route("mobile.profile.change-password.proceed"), {
        onError: (errors) => {
            console.error(errors);
        },
        onSuccess: () => {
            toast.success("Password berhasil diubah");
        },
    });
};
</script>
