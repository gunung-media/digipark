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

        <form class="mt-6 px-4" @submit.prevent="handleSubmit">
            <RadioGroup
                label="Tipe"
                :options="[
                    { label: 'Pengunduran Diri', value: 'pengunduran_diri' },
                    {
                        label: 'Pemutusan Hubungan Kerja',
                        value: 'pemutusan_hubungan_kerja',
                    },
                ]"
                name="Tipe"
                layout="vertical"
                v-model="form.type"
                :error="form.errors.type"
                :isRequired="true"
            />

            <SignaturePad
                ref="signaturePadRef"
                label="Tanda Tangan"
                @update:signature="updateSignature"
                :error="form.errors.signature"
            />
            <div class="mt-28">
                <Button title="Simpan" type="primary" />
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, router, useForm } from "@inertiajs/vue3";
import Button from "@/components/Button/index.vue";
import Back from "@/components/Back/index.vue";
import RadioGroup from "@/components/RadioGroup/index.vue";
import SignaturePad from "@/components/SignaturePad/index.vue";
import { ref } from "vue";
import { toast } from "vue3-toastify";
const form = useForm({
    type: "",
    signature: "",
});

const signaturePadRef = ref();
const handleSubmit = async () => {
    // Save the signature to base64 and store it in the form
    await signaturePadRef.value?.handleSaveSignature();
    if (!form.signature || form.signature == "") {
        toast.error("Tanda tangan harus diisi");
        return;
    }

    form.post(route("mobile.service.claim-jht.store"), {
        onError: (errors) => {
            console.error(errors);
        },
        onSuccess: () => {
            console.log("yeay");
        },
    });
};

const updateSignature = (signatureBase64: string) => {
    form.signature = signatureBase64;
};
</script>
