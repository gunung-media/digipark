<template>
    <Head title="Login" />
    <div class="">
        <Back />

        <h1 class="text-2xl font-semibold mt-4 text-gray-800 p-4">Login</h1>

        <div class="flex flex-col justify-between px-4 mt-5 h-[77vh]">
            <form class="space-y-4">
                <Input
                    label="Email"
                    id="email"
                    placeholder="Masukan Email"
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
            </form>
            <div>
                <Button title="Masuk" type="primary" @click="submitForm" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
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
    router.visit(route("mobile.home"));
};
</script>
