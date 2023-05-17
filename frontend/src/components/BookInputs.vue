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
        label: "Grams",
        multiplayer: 1,
    },
    {
        label: "kilograms",
        multiplayer: 1000,
    },
]);
</script>

<template>

    <FormField description="Please provide the weight." label="Weight" id="weight" :errors="errors.get('weight')">
        <FormFieldUnitable v-model="form.weight" v-slot="{inputValue, inputChanged}" :units="units">
            <input :value="inputValue" @change="$event => inputChanged($event.target.value)" required class="form__field__input" id="weight" type="number" placeholder="Enter Weight..." />
        </FormFieldUnitable>
    </FormField>
</template>