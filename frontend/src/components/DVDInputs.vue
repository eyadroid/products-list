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

const sizes = ref([
  {
    label: 'Megabytes',
    multiplayer: 1024 * 1024
  },
  {
    label: 'Kilobytes',
    multiplayer: 1024
  },
  {
    label: 'Bytes',
    multiplayer: 1
  }
])
</script>

<template>
  <FormField description="Please provide size." label="Size" id="size" :errors="errors.get('size')">
    <FormFieldUnitable
      :value="modelValue.size"
      @update:modelValue="(val) => updateValue('size', val)"
      v-slot="{ inputValue, inputChanged }"
      :units="sizes"
    >
      <input
        :value="inputValue"
        @change="($event) => inputChanged($event.target.value)"
        required
        class="form__field__input"
        id="size"
        type="number"
        step="0.01"
        placeholder="Enter Size..."
      />
    </FormFieldUnitable>
  </FormField>
</template>
