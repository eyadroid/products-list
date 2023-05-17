<script setup lang="ts">
import FormField from '@/components/FormField.vue';

defineProps<{
    form: object,
    errors: object,
}>()
</script>

<template>
    <FormField  description="Please provide width in cm." label="Width" id="width" :errors="errors.get('width')">
        <input v-model="form.width" required class="form__field__input" id="width" type="number" step="0.01" placeholder="Enter Width..." />
    </FormField>

    <FormField  description="Please provide length in cm." label="Length" id="length" :errors="errors.get('length')">
        <input v-model="form.length" required class="form__field__input" id="length" type="number" step="0.01" placeholder="Enter Length..." />
    </FormField>  

    <FormField description="Please provide height in cm."  label="Height" id="height" :errors="errors.get('height')">
        <input v-model="form.height" required class="form__field__input" id="height" type="number" step="0.01" placeholder="Enter Height..." />
    </FormField>  
</template>