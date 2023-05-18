<script setup lang="ts">
import { ref } from 'vue'
import FormField from '@/components/FormField.vue'
import FormFieldUnitable from './FormFieldUnitable.vue'

defineProps<{
  form: object
  errors: object
}>()

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
    <FormFieldUnitable v-model="form.size" v-slot="{ inputValue, inputChanged }" :units="sizes">
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
