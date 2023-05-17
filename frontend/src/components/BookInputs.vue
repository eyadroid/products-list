<script setup lang="ts">
import { ref } from 'vue';
import FormField from '@/components/FormField.vue';
import FormFieldUnitable from './FormFieldUnitable.vue';

defineProps<{
    form: object,
    errors: object,
}>()

const units = ref([
    {
        label: "kilograms",
        multiplayer: 1000,
    },
    {
        label: "Grams",
        multiplayer: 1,
    },
]);
</script>

<template>

    <FormField description="Please provide the weight." label="Weight" id="weight" :errors="errors.get('weight')">
        <FormFieldUnitable v-model="form.weight" v-slot="{inputValue, inputChanged}" :units="units">
            <input :value="inputValue" @change="$event => inputChanged($event.target.value)" required class="form__field__input" id="weight" type="number" step="0.01" placeholder="Enter Weight..." />
        </FormFieldUnitable>
    </FormField>
</template>