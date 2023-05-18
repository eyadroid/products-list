<script setup lang="ts">
import { ref } from 'vue'
import FormField from '@/components/FormField.vue'
import FormFieldUnitable from './FormFieldUnitable.vue'

const props = defineProps<{
  modelValue: any
  errors: object
}>()

const emit = defineEmits<{
  'update:modelValue': number
}>()

function updateValue(key: string, value: any) {
  emit('update:modelValue', { ...props.modelValue, [key]: value })
}

const units = ref([
  {
    label: 'kilograms',
    multiplayer: 1000
  },
  {
    label: 'Grams',
    multiplayer: 1
  }
])
</script>

<template>
  <FormField
    description="Please provide the weight."
    label="Weight"
    id="weight"
    :errors="errors.get('weight')"
  >
    <FormFieldUnitable
      :value="modelValue.weight"
      @update:modelValue="(val) => updateValue('weight', val)"
      v-slot="{ inputValue, inputChanged }"
      :units="units"
    >
      <input
        :value="inputValue"
        @change="($event) => inputChanged($event.target.value)"
        required
        class="form__field__input"
        id="weight"
        type="number"
        step="0.01"
        placeholder="Enter Weight..."
      />
    </FormFieldUnitable>
  </FormField>
</template>
