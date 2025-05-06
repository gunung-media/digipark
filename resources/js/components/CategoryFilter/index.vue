<template>
    <div class="flex overflow-x-auto space-x-2 px-4 py-3">
        <button
            v-for="cat in categories"
            :key="cat"
            @click="$emit('update:modelValue', cat)"
            :class="[
                'px-4 py-2 rounded-full border text-sm',
                modelValue === cat
                    ? 'bg-green-500 text-white border-green-500'
                    : 'bg-white text-gray-700 border-gray-300',
            ]"
        >
            {{ cat }}
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    categories: Array,
    modelValue: String,
});
</script>
