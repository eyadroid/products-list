<script setup lang="ts">
import FormField from '@/components/FormField.vue';

defineProps<{
    form: object,
    errors: object,
}>()
</script>

<template>
    <FormField description="Please provide size in Bytes."  label="Size" id="size" :errors="errors.get('size')">
        <input v-model="form.size" required class="form__field__input" id="size" type="number" placeholder="Enter Size..." />
    </FormField>  
</template>