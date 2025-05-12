<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="isRequired" class="text-red-500 ml-1">*</span>
        </label>
        <input
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            :required="isRequired"
            @input="
                $emit(
                    'update:modelValue',
                    ($event.target as HTMLInputElement).value,
                )
            "
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 p-3"
        />
    </div>
</template>

<script setup lang="ts">
defineProps<{
    label: string;
    modelValue: string;
    id: string;
    type?: string;
    placeholder?: string;
    isRequired?: boolean;
}>();

defineEmits<{
    (e: "update:modelValue", value: string): void;
}>();
</script>
