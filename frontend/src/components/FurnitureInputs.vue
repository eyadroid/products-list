<script setup lang="ts">
import FormField from '@/components/FormField.vue'

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
</script>

<template>
  <FormField
    description="Please provide width in cm."
    label="Width"
    id="width"
    :errors="errors.get('width')"
  >
    <input
      :value="modelValue.width"
      @change="updateValue('width', $event.target.value)"
      required
      class="form__field__input"
      id="width"
      type="number"
      step="0.01"
      placeholder="Enter Width..."
    />
  </FormField>

  <FormField
    description="Please provide length in cm."
    label="Length"
    id="length"
    :errors="errors.get('length')"
  >
    <input
      :value="modelValue.length"
      @change="updateValue('length', $event.target.value)"
      required
      class="form__field__input"
      id="length"
      type="number"
      step="0.01"
      placeholder="Enter Length..."
    />
  </FormField>

  <FormField
    description="Please provide height in cm."
    label="Height"
    id="height"
    :errors="errors.get('height')"
  >
    <input
      :value="modelValue.height"
      @change="updateValue('height', $event.target.value)"
      required
      class="form__field__input"
      id="height"
      type="number"
      step="0.01"
      placeholder="Enter Height..."
    />
  </FormField>
</template>
