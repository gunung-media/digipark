<template>
    <Head title="Login" />
    <div class="">
        <Back />

        <h1 class="text-2xl font-semibold mt-4 text-gray-800 p-4">Login</h1>

        <div class="px-4 mt-5 flex-grow">
            <form
                method="POST"
                class="space-y-4 flex flex-col min-h-[75vh]"
                @submit.prevent="submitForm"
            >
                <Input
                    label="Email"
                    id="email"
                    placeholder="Masukan Email"
                    v-model="form.email"
                    type="email"
                    :error="form.errors.email"
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

                <div class="mt-auto pt-4">
                    <Button title="Masuk" type="primary" class="w-full" />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import Input from "@/components/Input/index.vue";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import { useToastFlash } from "@/composables/useToastFlash";

const form = useForm({
    email: "",
    password: "",
});

const submitForm = () => {
    form.post(route("mobile.login.proceed"));
};

useToastFlash();
</script>
