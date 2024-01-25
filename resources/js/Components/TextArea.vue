<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const textarea = ref(null);

</script>

<template>
    <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="model" ref="textarea">
        <slot />
    </textarea>
</template>
