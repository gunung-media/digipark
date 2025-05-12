<template>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
            <span v-if="isRequired" class="text-red-500 ml-1">*</span>
        </label>
        <div
            :class="
                layout === 'horizontal'
                    ? 'flex items-center space-x-4'
                    : 'flex flex-col space-y-2'
            "
        >
            <label
                v-for="option in options"
                :key="option.value"
                class="flex items-center"
            >
                <input
                    type="radio"
                    :value="option.value"
                    v-model="model"
                    :name="name"
                    :class="
                        error
                            ? 'text-red-500 focus:text-red-500'
                            : 'text-green-500 focus:ring-green-500'
                    "
                    :required="isRequired"
                />
                <span class="ml-2">{{ option.label }}</span>
            </label>
            <label v-if="error" class="text-red-500 text-sm mt-2">
                {{ error }}
            </label>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    label: string;
    options: Array<{ label: string; value: string }>;
    name: string;
    layout?: "horizontal" | "vertical";
    modelValue: string;
    isRequired?: boolean;
    error?: string;
}>();

const emit = defineEmits(["update:modelValue"]);
const model = defineModel("modelValue");
</script>
