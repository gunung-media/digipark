<template>
    <div v-if="job">
        <Head :title="job.name_job" />
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
            <div v-html="job.description" class="rich-text-content"></div>
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
    ExclamationCircleIcon,
} from "@heroicons/vue/24/solid";
import { useToastFlash } from "@/composables/useToastFlash";

const page = usePage();
const storageUrl = computed(() => page.props.storageUrl);

const props = defineProps({
    job: Object,
});

const selected = ref("main");

const applyJob = () => {
    router.visit(route("mobile.job.apply", { id: props!.job!.id }));
};

useToastFlash();
</script>

<style scoped>
:deep(.rich-text-content) {
    font-size: 0.875rem !important;
    font-weight: 300 !important;
    line-height: 1.6 !important;
    color: #374151 !important;
}

:deep(.rich-text-content p) {
    margin: 0 0 1em 0 !important;
    text-indent: 0 !important;
}

:deep(.rich-text-content ul),
:deep(.rich-text-content ol) {
    padding-left: 1.5em !important;
    margin-bottom: 1em !important;
}

:deep(.rich-text-content li) {
    margin-bottom: 0.5em !important;
}

:deep(.rich-text-content h1),
:deep(.rich-text-content h2),
:deep(.rich-text-content h3) {
    margin: 1em 0 0.5em 0 !important;
    font-weight: 600 !important;
}

:deep(.rich-text-content br + br) {
    display: none !important;
}

:deep(.rich-text-content table) {
    margin-left: 0 !important;
    width: 100% !important;
    border-collapse: collapse !important;
    margin-bottom: 1em !important;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
    text-align: left !important;
}

:deep(.rich-text-content th),
:deep(.rich-text-content td) {
    border: 1px solid #d1d5db !important;
    padding: 0.5em 0.75em !important;
}

:deep(.rich-text-content thead) {
    background-color: #f9fafb !important;
    font-weight: 600 !important;
}
</style>
