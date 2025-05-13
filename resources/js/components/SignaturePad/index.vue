<template>
    <div class="relative mt-7">
        <label
            class="block text-sm font-medium mb-1"
            :class="error ? 'text-red-500' : 'text-gray-700'"
        >
            {{ label }}
        </label>
        <div
            class="relative border rounded shadow"
            :class="error ? 'border-red-500' : 'border-gray-700-500/50'"
        >
            <VueSignaturePad
                ref="signature"
                height="200px"
                width="350px"
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
                    class="grid p-2 bg-white rounded-md shadow-md place-items-center hover:bg-gray-50 cursor-pointer"
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
                    class="grid p-2 bg-white rounded-md shadow-md place-items-center hover:bg-gray-50 cursor-pointer"
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
                    class="grid p-2 bg-white rounded-md shadow-md place-items-center hover:bg-gray-50 cursor-pointer"
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

        <label v-if="error" class="text-red-500 text-sm mt-2">
            {{ error }}
        </label>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { VueSignaturePad } from "@selemondev/vue3-signature-pad";

defineProps<{
    label: string;
    error?: string;
}>();

const options = ref({
    penColor: "rgb(0,0,0)",
    backgroundColor: "rgb(255, 255, 255)",
    maxWidth: 1,
    minWidth: 1,
});

// @ts-expect-error
const signature = ref<Signature>();

function handleUndo() {
    return signature.value?.undo();
}

function handleClearCanvas() {
    return signature.value?.clearCanvas();
}

const emit = defineEmits<{
    (e: "update:signature", payload: string): void;
}>();

function handleSaveSignature() {
    const signatureData = signature.value?.saveSignature();
    if (signatureData) {
        emit("update:signature", signatureData);
    }
}
defineExpose({
    handleSaveSignature,
});
</script>
