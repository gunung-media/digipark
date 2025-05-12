<template>
    <Head title="Lowongan Staff Admin" />
    <div>
        <Back heading="Lowongan Staff Admin" />

        <div class="flex justify-center my-6">
            <img
                src="@/assets/images/guaranteed_medicine.png"
                alt="Job Illustration"
                class="w-32 h-32"
            />
        </div>

        <div class="text-center font-semibold text-gray-800">
            <p>CV. Bintang Kejora</p>
            <p>Jalan Menteng XII, No 1 Palangka Raya</p>
        </div>

        <div class="mt-6 space-y-4 px-4">
            <div
                :class="[
                    'flex justify-between items-center p-4 rounded-xl border',
                    selected === 'admin'
                        ? 'border-green-500 bg-green-50'
                        : 'border-gray-300',
                ]"
                @click="selected = 'admin'"
            >
                <div class="flex items-center space-x-3">
                    <div
                        :class="[
                            'w-5 h-5 rounded-full border-2',
                            selected === 'admin'
                                ? 'border-green-500 bg-green-500'
                                : 'border-gray-400',
                        ]"
                    ></div>
                    <span class="text-gray-800">Jabatan Admin</span>
                </div>
                <span class="text-gray-800">Rp. 3 jt / bulan</span>
            </div>

            <div
                :class="[
                    'flex justify-between items-center p-4 rounded-xl border relative',
                    selected === 'operator'
                        ? 'border-green-500 bg-green-50'
                        : 'border-gray-300',
                ]"
                @click="selected = 'operator'"
            >
                <div class="flex items-center space-x-3">
                    <div
                        :class="[
                            'w-5 h-5 rounded-full border-2',
                            selected === 'operator'
                                ? 'border-green-500 bg-green-500'
                                : 'border-gray-400',
                        ]"
                    ></div>
                    <span class="text-gray-800">Jabatan Operator</span>
                </div>
                <span class="text-gray-800">Rp. 3,5jt / bulan</span>
                <span
                    class="absolute top-[-10px] right-[-10px] bg-green-500 text-white text-xs rounded-full px-2 py-0.5"
                >
                    Rekomendasi
                </span>
            </div>
        </div>

        <div class="mt-6 px-4">
            <p class="font-semibold text-gray-800 mb-2">Persyaratan :</p>
            <ul class="space-y-3 text-gray-500">
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <UsersIcon class="w-5" />
                    <span>Laki-Laki / Perempuan</span>
                </li>
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <ChatBubbleLeftRightIcon class="w-5" />
                    <span>Usia maksimal 30 thn</span>
                </li>
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <BriefcaseIcon class="w-5" />
                    <span>Bersedia mengikuti pelatihan selama 1 bln</span>
                </li>
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <ExclamationCircleIcon class="w-5" />
                    <span>Minimal S1 atau sederajat</span>
                </li>
            </ul>
        </div>

        <div class="mt-8 px-4">
            <Button
                title="Daftar Lowongan ini"
                type="primary"
                @click="applyJob"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import {
    UsersIcon,
    ChatBubbleLeftRightIcon,
    BriefcaseIcon,
    ExclamationCircleIcon,
} from "@heroicons/vue/24/solid";

const selected = ref("operator"); // default selected job

const applyJob = () => {
    console.log("Applied for:", selected.value);
    router.visit(route("mobile.home"));
};
</script>
