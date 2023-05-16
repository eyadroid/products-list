<script setup lang="ts">
import FormField from '@/components/FormField.vue';

defineProps<{
    form: object,
    errors: object,
}>()
</script>

<template>
    <FormField description="Please provide weight in KG." label="Weight" id="weight" :errors="errors.get('weight')">
        <input v-model="form.weight" required class="form__field__input" id="weight" type="number" placeholder="Enter Weight..." />
    </FormField>  
</template>