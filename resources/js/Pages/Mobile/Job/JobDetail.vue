<template>
    <Head title="Lowongan Staff Admin" />
    <div v-if="job">
        <Back :heading="job.name_job" />

        <div class="flex justify-center my-6">
            <img
                :src="`${storageUrl}/${job.image ?? job.company.image}`"
                alt="Job Illustration"
            />
        </div>

        <div class="text-center font-semibold text-gray-800">
            <p>{{ job.company.name }}</p>
            <p class="text-sm font-thin">{{ job.company.address }}</p>
        </div>

        <div class="mt-6 space-y-4 px-4">
            <div
                :class="[
                    'flex justify-between items-center p-4 rounded-xl border relative',
                    selected === 'main'
                        ? 'border-green-500 bg-green-50'
                        : 'border-gray-300',
                ]"
                @click="selected = 'main'"
            >
                <div class="flex items-center space-x-3">
                    <div
                        :class="[
                            'w-5 h-5 rounded-full border-2',
                            selected === 'main'
                                ? 'border-green-500 bg-green-500'
                                : 'border-gray-400',
                        ]"
                    ></div>
                    <span class="text-gray-800">{{ job.name_job }}</span>
                </div>
                <span class="text-gray-800"
                    >Rp.
                    {{ new Intl.NumberFormat("id-ID").format(job.salary) }} /
                    bulan</span
                >
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
                    <span
                        v-tooltip="
                            `Dibutuhkan: ${job.total_needed_man} Laki-Laki, ${job.total_needed_woman} Perempuan`
                        "
                        class="cursor-help"
                    >
                        {{ job.total_needed_man !== 0 ? "Laki-Laki" : "" }}
                        {{
                            job.total_needed_man !== 0 &&
                            job.total_needed_woman !== 0
                                ? " / "
                                : ""
                        }}
                        {{ job.total_needed_woman !== 0 ? "Perempuan" : "" }}
                    </span>
                </li>
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <ChatBubbleLeftRightIcon class="w-5" />
                    <span
                        >Spesialisasi:
                        {{ job.special ?? "Tidak disebutkan" }}</span
                    >
                </li>
                <li class="flex items-center space-x-2 border-b-1 py-5">
                    <ExclamationCircleIcon class="w-5" />
                    <span>Minimal {{ job.minimal_education }}</span>
                </li>
            </ul>
        </div>

        <div class="mt-6 px-4">
            <p class="font-semibold text-gray-800 mb-2 text-base">
                Info Tambahan :
            </p>
            <div v-html="job.description" class="text-sm font-light"></div>
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
import { computed, ref } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import {
    UsersIcon,
    ChatBubbleLeftRightIcon,
    BriefcaseIcon,
    ExclamationCircleIcon,
} from "@heroicons/vue/24/solid";

const page = usePage();
const storageUrl = computed(() => page.props.storageUrl);

defineProps({
    job: Object,
});

const selected = ref("main");

const applyJob = () => {
    console.log("Applied for:", selected.value);
    router.visit(route("mobile.home"));
};
</script>
