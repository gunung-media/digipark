<template>
    <Head title="Klaim JHT" />
    <div>
        <Back heading="Klaim JHT" />

        <div class="flex justify-center my-6">
            <img
                src="@/assets/images/guaranteed_medicine.png"
                alt="Job Illustration"
                class="w-32 h-32"
            />
        </div>

        <div class="mt-6 px-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Tipe</label
                >
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input
                            type="radio"
                            value="Pengunduran Diri"
                            class="text-green-500 focus:ring-green-500"
                        />
                        <span class="ml-2">Pengunduran Diri</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="radio"
                            value="Pemutusan Hubungan Kerja"
                            class="text-green-500 focus:ring-green-500"
                        />
                        <span class="ml-2">Pemutusan Hubungan Kerja</span>
                    </label>
                </div>
            </div>
            <div class="relative mt-7">
                <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Tanda Tangan</label
                >
                <div class="relative border">
                    <VueSignaturePad
                        ref="signature"
                        height="200px"
                        width="400px"
                        :max-width="options.maxWidth"
                        :min-width="options.minWidth"
                        :options="{
                            penColor: options.penColor,
                            backgroundColor: options.backgroundColor,
                        }"
                    />
                    <div class="absolute flex flex-col space-y-2 top-3 right-4">
                        <button
                            type="button"
                            class="grid p-2 bg-white rounded-md shadow-md place-items-center"
                            @click="handleUndo"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    fill="none"
                                    stroke="#000"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 8H5V3m.291 13.357a8 8 0 1 0 .188-8.991"
                                />
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="grid p-2 bg-white rounded-md shadow-md place-items-center"
                            @click="handleClearCanvas"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    fill="none"
                                    stroke="#000"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.5 8.5h-9l-.76 3.8a1 1 0 0 0 .21.83a1 1 0 0 0 .77.37h8.56a1.002 1.002 0 0 0 .77-.37a1.001 1.001 0 0 0 .21-.83zm0-3a1 1 0 0 1 1 1v2h-11v-2a1 1 0 0 1 1-1H4a1 1 0 0 0 1-1v-2a2 2 0 1 1 4 0v2a1 1 0 0 0 1 1zm-3 8V11"
                                />
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="grid p-2 bg-white rounded-md shadow-md place-items-center"
                            @click="handleSaveSignature"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    fill="#000"
                                    d="M21 7v14H3V3h14zm-2 .85L16.15 5H5v14h14zM12 18q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6zM5 7.85V19V5z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-28 px-4">
            <Button title="Simpan" type="primary" @click="applyJob" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import { onMounted, ref } from "vue";
import { VueSignaturePad } from "@selemondev/vue3-signature-pad";
import type { CanvasSignature } from "@selemondev/vue3-signature-pad";

const options = ref({
    penColor: "rgb(0,0,0)",
    backgroundColor: "rgb(255, 255, 255)",
    maxWidth: 1,
    minWidth: 1,
});

const colors = [
    {
        color: "rgb(51, 133, 255)",
    },
    {
        color: "rgb(85, 255, 51)",
    },
    {
        color: "rgb(255, 85, 51)",
    },
];
const signature = ref<Signature>();

function handleUndo() {
    return signature.value?.undo();
}

function handleClearCanvas() {
    return signature.value?.clearCanvas();
}

function handleSaveSignature() {
    return (
        signature.value?.saveSignature() &&
        alert(signature.value?.saveSignature())
    );
}

const applyJob = () => {
    router.visit(route("mobile.home"));
};
</script>
